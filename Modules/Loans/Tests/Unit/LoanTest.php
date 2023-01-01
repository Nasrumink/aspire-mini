<?php

namespace Modules\Loans\Tests\Unit;

use Tests\TestCase;
use Modules\Users\Services\UserService;
use Modules\Loans\Services\LoanService;
use Faker\Factory;
use Modules\Users\Models\{User};
use Modules\Loans\Models\{Loan};
use Illuminate\Http\Request;
use Modules\Users\Tests\Unit\UserTest;
use Illuminate\Support\Facades\Auth;
class LoanTest extends TestCase
{
    public function testCreateLoan()
    {
        $arr = (new UserTest)->testAuthenticateLogin();
        $this->refreshApplication();

        //Create Loan
        $arr = $this->prepareLoanParams($arr);
        $loan = (new LoanService)->createLoan($arr);
        $this->assertDatabaseHas('loans', ['id' => $loan->id]);
        return $loan;
    }

    public function prepareLoanParams($arr)
    {
        $faker = Factory::create();
        $amt = $faker->numberBetween(1, 9000);

        $user = User::where('email',$arr['email'])->first();

        $arr['user_id'] = $user->id;
        $arr['loan_date'] = date('Y-m-d');
        $arr['amount'] = $amt;
        $arr['term'] = $faker->randomDigit;
        $arr['scheduled_repayments'] = [
            ["amount" =>  $amt/3 , 'payment_date' => date('Y-m-d', strtotime(now(). ' + 6 days'))],
            ["amount" =>  $amt/3 , 'payment_date' => date('Y-m-d', strtotime(now(). ' + 12 days'))],
            ["amount" =>  $amt/3 , 'payment_date' => date('Y-m-d', strtotime(now(). ' + 18 days'))]
        ];
        return $arr;
    }

    function testApproveLoan() 
    {
        $loan = Loan::where('status','PENDING')->latest()->first();
        if (!empty($loan)) {
            $arr['status'] = 'APPROVED';
            (new LoanService)->updateLoan($arr, $loan);
            $this->assertDatabaseHas('loans', ['id' => $loan->id, 'status' => 'APPROVED']);
        } {
            $this->assertTrue(true);
        }
    }

    function testGetLoans() {
        $loan = (new LoanService)->getLoansByRole([]);
        $this->assertNotEmpty($loan);
    }
}
