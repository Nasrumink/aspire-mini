<?php

namespace Modules\Loans\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Modules\Users\Models\{User};
use Modules\Users\Tests\Feature\UserApiTest;
use Modules\Loans\Tests\Unit\LoanTest;
use Modules\Users\Tests\Unit\UserTest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class LoanApiTest extends TestCase
{
    public function testCreateLoanApi()
    {
        $login = $this->testCustomerLoginApi();
        $arr = (new LoanTest)->prepareLoanParams(['email' => $login['email']]);
        $response = $this->json('POST', 'api/v1/loan',$arr,['HTTP_Authorization' => 'Bearer '.$login['token']])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "seq_id",
                    "id",
                    "user_id",
                    "amount",
                    "term",
                    "loan_date",
                    "repayment_frequency",
                    "status",
                    "scheduled_repayments" => [
                        '*' => [
                            "seq_id",
                            "id",
                            "loan_id",
                            "amount",
                            "payment_date",
                            "status"
                        ]
                    ]
                ]
            ]
        );
        return json_decode($response->getContent())->data;
    }

    public function testApproveLoanApi()
    {
        $loan = $this->testCreateLoanApi();
        $this->refreshApplication();
        $login = $this->testAdminLoginApi();
        $arr['status'] = 'APPROVED';
        $response = $this->json('PATCH', 'api/v1/loan/'.$loan->id,$arr,['HTTP_Authorization' => 'Bearer '.$login['token']])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "seq_id",
                    "id",
                    "user_id",
                    "amount",
                    "term",
                    "loan_date",
                    "repayment_frequency",
                    "status"
                ]
            ]
        );

        $this->assertDatabaseHas('loans', ['id' => $loan->id, 'status' => 'APPROVED']);

        return json_decode($response->getContent())->data;
    }

    public function testCustomerUserCreateApi()
    {
        $arr = (new UserTest)->prepareUserParams('CUSTOMER');
        $response = $this->json('POST', 'api/v1/user', $arr);
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'error',
                "message",
                "data" => [
                    "first_name",
                    "last_name",
                    "email",
                    "role",
                ]
            ]
        );
        $this->assertDatabaseHas('users', ['email' => $arr['email']]);
        return $arr;
    }

    public function testCustomerLoginApi() 
    {
        $this->refreshApplication();
        $arr = $this->testCustomerUserCreateApi();
        $response = $this->json('POST', 'api/v1/user/login', $arr);
        $response->assertStatus(Response::HTTP_OK)
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
        $response = $this->json('POST', 'api/v1/user/login', $arr);
        $response->assertStatus(Response::HTTP_OK)
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


}
