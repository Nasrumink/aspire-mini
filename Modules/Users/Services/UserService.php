<?php

namespace Modules\Users\Services;

use Modules\Users\Models\{User};
use Illuminate\Support\Facades\Auth;
use Modules\Users\Enums\Roles;
use Illuminate\Support\Facades\Hash;
class UserService
{
    // To get the list of users logged in role and by given filters
    function getUsersByRole(array $arr) : object 
    {
        $user = new User();

        if (!empty(Auth::user()) && Auth::user()->role == Roles::CUSTOMER) //Fetch user details of logged in user if the role is not admin
            $user = $user->where('id', Auth::user()->getAttributes()['id']);
    
        $user = $user->filter($arr)->orderBy('id','desc')->get();

        if (count($user) < 1)
            throw new \Exception('No records found');

        return $user;    
    }

    //To create a user 
    function createUser(array $arr) : User 
    {
        return User::create([
            'password' => Hash::make($arr['password']),
            'first_name' => $arr['first_name'],
            'last_name' => $arr['last_name'],
            'email' => $arr['email'],
            'role' => $arr['role']
        ]);
    }

    //To update a user
    function updateUser(array $arr, User $user) : User 
    {
        if (!empty(Auth::user()) && Auth::user()->role == Roles::CUSTOMER) //Update user details of logged in user if the role is not admin
            $user = $user->where('id', Auth::user()->getAttributes()['id'])->first();

        $user->first_name = isset($arr['first_name']) ? $arr['first_name'] : $user->first_name;
        $user->last_name = isset($arr['last_name']) ? $arr['last_name'] : $user->last_name;
        $user->role = isset($arr['role']) ? $arr['role'] : $user->role;
        $user->save();
        return $user;
    }

    //To authenticate user login credentials
    function authenticateLogin($request) : string 
    {
        if(!Auth::attempt($request->only(['email', 'password'])))
            throw new \Exception('Email & Password does not match with our record.');

        $user = User::where('email', $request->email)->first();
        return $user->createToken("API TOKEN")->plainTextToken;
    }

}