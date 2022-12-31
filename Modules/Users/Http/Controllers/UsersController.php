<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Models\User;
use Modules\Users\Http\Requests\{UserRequest,LoginRequest};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Services\UserService;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param UserRequest $request
     * @return Renderable
     * @path GET /api/v1/user
     */
    public function index(UserRequest $request) 
    {
        $users =  (new UserService)->getUsersByRole($request->all());
        return response()->json(["error" => false, "message" => "Success", "data" => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRequest $request
     * @return Renderable
     * @path POST /api/v1/user
     */
    public function store(UserRequest $request) 
    {
        $user =  (new UserService)->createUser($request->all());

        return response()->json([
            'error' => false,
            'message' => 'User Created Successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param User $user
     * @return Renderable
     * @path PATCH /api/v1/user
     */
    public function update(User $user,UserRequest $request) 
    {
        $user =  (new UserService)->updateUser($request->all(), $user);

        return response()->json([
            'error' => false,
            'message' => 'User Updated Successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @param UserRequest $UserRequest
     * @return Renderable
     * @path DELETE /api/v1/user
     */
    public function destroy(User $user,UserRequest $request) 
    {
        $user->delete();
        return response()->json(["error" => false, "message" => "User deleted successfully"], 200);
    }

    /**
     * Login The User
     * @param LoginRequest $request
     * @return token
     * @path POST /api/v1/user/login
     */
    public function loginUser(LoginRequest $request) 
    {
        $token =  (new UserService)->authenticateLogin($request);
        return response()->json([
            'error' => false,
            'message' => 'User Logged In Successfully',
            'token' => $token
        ], 200);
    }
}
