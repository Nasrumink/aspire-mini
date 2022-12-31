<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('loan_number');
            $table->bigInteger('user_id')->index();
            $table->decimal('amount',10,2);
            $table->integer('term');
            $table->timestamp('loan_date');
            $table->enum('repayment_frequency',['WEEKLY','MONTHLY'])->default('WEEKLY');
            $table->enum('status',['PENDING','APPROVED','REJECTED','PAID'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            //$table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('scheduled_loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->index();
            $table->decimal('amount',10,2);
            $table->timestamp('payment_date');
            $table->enum('status',['PENDING','PAID'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            //$table->foreign('loan_id')->references('id')->on('loans');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}

