<?php

namespace Modules\Users\Tests\Unit;

use Tests\TestCase;
use Modules\Users\Services\UserService;
use Faker\Factory;
use Modules\Users\Models\{User};
use Illuminate\Http\Request;
class UserTest extends TestCase
{
    public function testCreateCustomer($assert = true)
    {
        //Create Customer user
        $arr = $this->prepareUserParams('CUSTOMER');
        $user = (new UserService)->createUser($arr);
        if ($assert)
            $this->assertDatabaseHas('users', ['email' => $arr['email']]);
        return $arr;
    }

    public function testCreateAdmin($assert = true)
    {
        //Create Admin User
        $arr = $this->prepareUserParams('ADMIN');
        $user = (new UserService)->createUser($arr);
        if ($assert)
            $this->assertDatabaseHas('users', ['email' => $arr['email']]);
        return $arr;
    }

    public function prepareUserParams($role)
    {
        $faker = Factory::create();
        $arr['password'] = $faker->password;
        $arr['first_name'] = $faker->firstName;
        $arr['last_name'] = $faker->lastName;;
        $arr['email'] = $faker->email;
        $arr['role'] = $role;
        return $arr;
    }

    function testUpdateUser($assert = true) 
    {
        $user = User::latest()->first();
        if (!empty($user)) {
            $arr['first_name'] = 'Updated '.$user->first_name;
            $arr['last_name'] = 'Updated '.$user->last_name;
            (new UserService)->updateUser($arr, $user);
            if ($assert)
                $this->assertDatabaseHas('users', ['id' => $user->id,'first_name' => $arr['first_name'], 'last_name' => $arr['last_name']]);
        }
    }

    function testAuthenticateLogin($assert = true)
    {
        $arr = $this->testCreateCustomer(false);
        $request = new Request();
        $request->merge(["email"=>$arr['email']]);
        $request->merge(["password"=>$arr['password']]);
        $token = (new UserService)->authenticateLogin($request);
        if ($assert)
            $this->assertNotEmpty($token);
    }

    function testGetUsers() {
        $users = (new UserService)->getUsersByRole([]);
        $this->assertNotEmpty($users);
    }
}
