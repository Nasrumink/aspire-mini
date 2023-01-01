<?php

namespace Modules\Repayments\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Modules\Users\Models\{User};
use Modules\Users\Tests\Feature\UserApiTest;
use Modules\Loans\Tests\Unit\LoanTest;
use Modules\Users\Tests\Unit\UserTest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RepaymentApiTest extends TestCase
{

    public function testCreateRepaymentApi()
    {
        $customer = $this->customerLoginApi();
        $this->refreshApplication();
        $loan = $this->createLoanApi($customer);
        $this->refreshApplication();
        $admin = $this->adminLoginApi();
        $this->refreshApplication();
        $this->approveLoanApi($admin,$loan);
        $this->refreshApplication();
        $customer = $this->loginUser($customer);

        $arr['amount'] = ceil($loan->amount/3);
        $arr['loan_id'] = $loan->id;

        $response = $this->json('POST', 'api/v1/repayment',$arr,['HTTP_Authorization' => 'Bearer '.$customer['token']])
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
        return json_decode($response->getContent());
    }
    public function createLoanApi($login)
    {
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

    public function approveLoanApi($login,$loan)
    {
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

        return $loan;
    }

    public function customerUserCreateApi()
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

    public function customerLoginApi() 
    {
        $this->refreshApplication();
        $arr = $this->customerUserCreateApi();
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

    public function adminLoginApi() 
    {
        $arr = $this->adminUserCreateApi();
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

    public function adminUserCreateApi()
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

    public function loginUser($arr) {
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
}
