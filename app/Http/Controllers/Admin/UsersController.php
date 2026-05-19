<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('title', env('SUPERADMIN'));
        })
        ->orderBy('id', 'DESC')
        ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
       
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {   
        if (User::where('email', $request->email)->exists()) {
            session()->flash('warning', 'This email is already registered.'); 
            return redirect()->back();
                 
        }
        //dd($request->all());
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        $mailResult = $this->sendAccountCreatedMailFromConnectedGmail(Auth::user(), $request->email, $request->all());

        session()->flash('success', 'User has been successfully added!');

        if (! $mailResult['status']) {
            session()->flash('warning', $mailResult['message']);
        }

        return redirect()->route('admin.users.index');
    }

    private function sendAccountCreatedMailFromConnectedGmail(?User $admin, string $to, array $data): array
    {
        if (
            ! $admin ||
            ! $admin->is_email_connected ||
            $admin->email_provider !== 'gmail' ||
            ! $admin->connected_email ||
            ! $admin->google_refresh_token
        ) {
            return [
                'status' => false,
                'message' => 'User was created, but account email was not sent. Please connect admin Gmail and try again.',
            ];
        }

        try {
            $clientId = env('GOOGLE_CLIENT_ID');
            $clientSecret = env('GOOGLE_CLIENT_SECRET');

            if (! $clientId || ! $clientSecret) {
                return [
                    'status' => false,
                    'message' => 'User was created, but Google mail settings are missing.',
                ];
            }

            $client = new Client();
            $client->setClientId($clientId);
            $client->setClientSecret($clientSecret);
            $client->setAccessType('offline');
            $client->setScopes(['https://www.googleapis.com/auth/gmail.modify']);
            $client->setAccessToken([
                'access_token' => $admin->google_access_token,
                'refresh_token' => $admin->google_refresh_token,
            ]);

            if ($client->isAccessTokenExpired()) {
                $token = $client->fetchAccessTokenWithRefreshToken($admin->google_refresh_token);

                if (isset($token['error'])) {
                    return [
                        'status' => false,
                        'message' => 'User was created, but Gmail session expired. Please reconnect admin Gmail.',
                    ];
                }

                $admin->update([
                    'google_access_token' => $token['access_token'],
                    'google_refresh_token' => $token['refresh_token'] ?? $admin->google_refresh_token,
                ]);

                $client->setAccessToken([
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? $admin->google_refresh_token,
                ]);
            }

            $subject = 'Account Created';
            $htmlBody = view('admin.emails.signup', [
                'data' => $data,
            ])->render();

            $rawMessage = implode("\r\n", [
                'From: ' . $admin->connected_email,
                'To: ' . $to,
                'Subject: =?UTF-8?B?' . base64_encode($subject) . '?=',
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'Content-Transfer-Encoding: base64',
                '',
                chunk_split(base64_encode($htmlBody)),
            ]);

            $message = new Message();
            $message->setRaw(rtrim(strtr(base64_encode($rawMessage), '+/', '-_'), '='));

            (new Gmail($client))->users_messages->send('me', $message);

            return ['status' => true];
        } catch (\Throwable $e) {
            Log::error('Account created Gmail send failed: ' . $e->getMessage(), [
                'admin_id' => $admin->id ?? null,
                'to' => $to,
            ]);

            return [
                'status' => false,
                'message' => 'User was created, but account email could not be sent from connected Gmail.',
            ];
        }
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');
        
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        session()->flash('success', 'User has been successfully updated!');
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();
        session()->flash('error', 'User has been successfully deleted!');
        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
	
	public function getUsersForSelect2(Request $request)
	{
		abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$search = $request->input('q');
		$element = $request->input('element');
		if($element=='from')
		{
			$users = User::query()
			->where('email',auth()->user()->email)
				->limit(1)
				->get();
		}
		else 
		{
			$users = User::query()
			->when($search, function ($query, $search) {
				$query->where('name', 'like', "%{$search}%")
					  ->orWhere('email', 'like', "%{$search}%");
			})
			->limit(10)
			->get();
		}

		$formattedUsers = $users->map(function ($user) {
			return [
				'id' => $user->id,
				'text' => "{$user->name} | {$user->email}",
			];
		});

		return response()->json($formattedUsers);
	}

    # for logout user
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('notif_shown');

        return redirect()->route('login')->with('message', 'You have been logged out successfully.');
    }

    # update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();  // get currently logged-in user

        # validate input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'zoom_ext' => 'nullable|string|max:500',
            'open_solar_password' => 'nullable|string|max:500',
            'password' => 'nullable|string|max:500',
            
        ]);

        # update fields
        $user->name    = $validated['name'];
        $user->phone   = $validated['phone'];
        $user->address = $validated['address'] ?? null;
        $user->link    = $validated['link'] ?? null;

        # update password only if provided
        if ($request->filled('password')) {
            $user->password = \Hash::make($validated['password']);
        }

        $user->zoom_ext    = $validated['zoom_ext'] ?? null;
        $user->open_solar_password    = $validated['open_solar_password'] ?? null;

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    # for notification
    public function fetchNotification()
    {
        $notifications = auth()->user()
        ->unreadNotifications()
        ->latest()
        ->take(10)
        ->get();

        return response()->json([
            'count' => auth()->user()->unreadNotifications->count(),
            'html' => view('partials.notifications_list', compact('notifications'))->render(),
        ]);
    }
}
