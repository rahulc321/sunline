<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class UsersApiController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/userLogin",
     *     summary="User Login",
     *     tags={"Leads"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="kap@yopmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="kap@yopmail.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your_access_token"),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=31536000)
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     security={}
     * )
     */
    public function userLogin(Request $request)
    {
        try {
            # validate request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            # attempt login
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                'message' => 'Email or password is incorrect',
                'status' => 500,
                'success' => false,
                ],500);
            }

            # get user & create token
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;

            return response()->json([
                'user' => $user,
                
                'current_role' =>@$user->roles,
                'token' => $token,
                'status' => 200,
                'success' => true,
                'message' => 'Login successful',

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 500,
                'success' => false,
            ],500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/createLead",
     *     summary="Create a new lead",
     *     tags={"Leads"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name","last_name","email"},
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="+911234567890"),
     *             @OA\Property(property="address", type="string", example="123 Street, City, Country"),
     *             @OA\Property(property="lead_source", type="string", example="5")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Lead created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     ),
     * )
     */
    public function createLead(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'lead_source' => 'nullable|string|max:100',
            
        ]);

        $lead = \App\Models\Lead::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully.',
            'data' => $lead
        ], 201);
    }

}
