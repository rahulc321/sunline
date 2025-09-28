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
use Symfony\Component\HttpFoundation\Response;
use Auth;

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
        //dd($request->all());
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        session()->flash('success', 'User has been successfully added!');   
        return redirect()->route('admin.users.index');
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
            
        ]);

        # update fields
        $user->name    = $validated['name'];
        $user->phone   = $validated['phone'];
        $user->address = $validated['address'] ?? null;
        $user->link    = $validated['link'] ?? null;

        # update password only if provided
        if ($request->filled('password')) {
           // $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
