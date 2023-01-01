<?php

namespace Modules\Loans\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Modules\Users\Models\{User};
use Modules\Users\Tests\Feature\UserApiTest;
use Illuminate\Http\Response;
class LoanApiTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /* public function testCreateLoanApi()
    {
        

        $arr = (new UserApiTest)->testCustomerLoginApi(false);
        dd($arr);

        $response = $this->json('POST', 'api/v1/user', $arr)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "first_name",
                    "last_name",
                    "email",
                    "role",
                    "id"
                ]
            ]
        );
            
        $this->assertDatabaseHas('users', ['email' => $arr['email']]);

        return $arr;
    }

    public function testAdminUserCreateApi()
    {
        $arr = (new UserTest)->prepareUserParams('ADMIN');
        $response = $this->json('POST', 'api/v1/user', $arr)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "first_name",
                    "last_name",
                    "email",
                    "role",
                    "id"
                ]
            ]
        );
            
        $this->assertDatabaseHas('users', ['email' => $arr['email']]);

        return $arr;
    }

    public function testCustomerLoginApi() 
    {
        $arr = $this->testCustomerUserCreateApi();
        $response = $this->json('POST', 'api/v1/user/login', $arr)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "token"
            ]
        );
        $arr['token'] = json_decode($response->getContent())->token;
        return $arr;
    }

    public function testAdminLoginApi() 
    {
        $arr = $this->testAdminUserCreateApi();
        $response = $this->json('POST', 'api/v1/user/login', $arr)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "token"
            ]
        );
        $arr['token'] = json_decode($response->getContent())->token;
        return $arr;
    }

    public function testUserUpdateApi()
    {
        $login = $this->testAdminLoginApi();

        $user = User::latest()->first();
        $arr['first_name'] = 'Updated '.$user->first_name;
        $arr['last_name'] = 'Updated '.$user->last_name;

        $response = $this->json('PATCH', 'api/v1/user/'.$user->id, $arr,['HTTP_Authorization' => 'Bearer '.$login['token']])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "seq_id",
                    "id",
                    "first_name",
                    "last_name",
                    "email",
                    "role"
                ]
            ]
        );
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('users', ['id' => $user->id, 'first_name' => $arr['first_name'], 'last_name' => $arr['last_name']]);
    }

    public function testUserGetApi() {
        $login = $this->testAdminLoginApi();

        $response = $this->json('GET', 'api/v1/user',['HTTP_Authorization' => 'Bearer '.$login['token']])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [  
                    '*' => [
                        "seq_id",
                        "id",
                        "first_name",
                        "last_name",
                        "email",
                        "role"
                    ]
                ]
            ]
        );
    }

    public function testDeleteUserApi() {
        $login = $this->testAdminLoginApi(); 
        $user = User::where('role','CUSTOMER')->latest()->first();
        $response = $this->json('DELETE', 'api/v1/user/'.$user->id,[],['HTTP_Authorization' => 'Bearer '.$login['token']])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message"
            ]
        );       
    } */
}
