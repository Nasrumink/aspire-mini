<?php

namespace Modules\Users\Services;

use Modules\Users\Models\{User};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
use Illuminate\Support\Facades\Hash;
class UserService
{
    function getUsersByRole(array $arr) :object {
        $user = new User();

        if (Auth::user()->role == Roles::CUSTOMER) //Fetch user details of logged in user if the role is not admin
            $user = $user->where('id', Auth::user()->id);
    
        return $user->filter($arr)->get();
    }

    function createOrUpdateUser(array $arr, $user = '') : User {
        if (Auth::user()->role == Roles::CUSTOMER) //Update user details of logged in user if the role is not admin
            $user = $user->where('id', Auth::user()->id)->first();

        if (empty($user))
            $user = new User();
        
        $user->first_name = isset($arr['first_name']) ? $arr['first_name'] : $user->first_name;
        $user->last_name = isset($arr['last_name']) ? $arr['last_name'] : $user->last_name;
        $user->email = isset($arr['email']) ? $arr['email'] : $user->email;
        $user->role = isset($arr['role']) ? $arr['role'] : $user->role;
        $user->password = isset($arr['password']) ? Hash::make($arr['password']) : $user->password;
        $user->save();
        return $user;
    }

    function authenticateLogin($request) {
        if(Auth::attempt($request->only(['email', 'password']))){
            $user = User::where('email', $request->email)->first();
            return $user->createToken("API TOKEN")->plainTextToken;
        }
        return false;
    }

}