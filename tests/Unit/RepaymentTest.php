<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Users\Services\UserService;
use Modules\Loans\Services\LoanService;
use Modules\Repayments\Services\RepaymentService;
use Faker\Factory;
use Modules\Users\Models\{User};
use Modules\Repayments\Models\{Repayment};
use Modules\Loans\Models\{Loan};
use Illuminate\Http\Request;
use Tests\Unit\{UserTest,LoanTest};
use Illuminate\Support\Facades\Auth;
class RepaymentTest extends TestCase
{
    public function testCreateLoanRepayment($assert = true)
    {
        $loan = (new LoanTest)->testCreateLoan(false);
        
        $arr['amount'] = round($loan->amount/3,2);
        $arr['loan_id'] =$loan->id;

        //Create Loan repayment
        $loan = (new RepaymentService)->createRepayment($arr); // first payment
        $loan = (new RepaymentService)->createRepayment($arr); // second payment
        $loan = (new RepaymentService)->createRepayment($arr); // third payment

        if($assert)
            $this->assertNotEmpty($loan);

        if($assert)
            $this->assertDatabaseHas('repayments', ['loan_id' => $loan->id, 'loan_amount_paid' => $arr['amount']]);

        return $arr;
    }

    function testGetRepayments() {
        $repayments = (new RepaymentService)->getRepaymentsByRole([]);
        $this->assertNotEmpty($repayments);
    }
}
