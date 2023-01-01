<?php

namespace Modules\Users\Tests\Unit;

use Tests\TestCase;
use Modules\Users\Services\UserService;
use Faker\Factory;
use Modules\Users\Models\{User};
use Illuminate\Http\Request;
class UserTest extends TestCase
{
    public function testCreateCustomer()
    {
        //Create Customer user
        $arr = $this->prepareUserParams('CUSTOMER');
        $user = (new UserService)->createUser($arr);
        $this->refreshApplication();
        $this->assertDatabaseHas('users', ['email' => $arr['email']]);
        return $arr;
    }

    public function testCreateAdmin()
    {
        //Create Admin User
        $arr = $this->prepareUserParams('ADMIN');
        $user = (new UserService)->createUser($arr);
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

    function testUpdateUser() 
    {
        $user = User::latest()->first();
        if (!empty($user)) {
            $arr['first_name'] = 'Updated '.$user->first_name;
            $arr['last_name'] = 'Updated '.$user->last_name;
            (new UserService)->updateUser($arr, $user);
            $this->assertDatabaseHas('users', ['id' => $user->id,'first_name' => $arr['first_name'], 'last_name' => $arr['last_name']]);
        } else {
            $this->assertTrue(true);
        }
    }

    function testAuthenticateLogin()
    {
        $arr = $this->testCreateCustomer();
        $request = new Request();
        $request->merge(["email"=>$arr['email']]);
        $request->merge(["password"=>$arr['password']]);
        $token = (new UserService)->authenticateLogin($request);
        $this->refreshApplication();
        $this->assertNotEmpty($token);
        return $arr;
    }

    function testGetUsers() {
        $users = (new UserService)->getUsersByRole([]);
        $this->assertNotEmpty($users);
    }
}
