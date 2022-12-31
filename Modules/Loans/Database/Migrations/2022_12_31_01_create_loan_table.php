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
            $table->id('seq_id');
            $table->uuid('id');
            $table->uuid('user_id')->index();
            $table->decimal('amount',10,2)->default(0);
            $table->integer('term');
            $table->timestamp('loan_date');
            $table->enum('repayment_frequency',['WEEKLY','MONTHLY'])->default('WEEKLY');
            $table->enum('status',['PENDING','APPROVED','REJECTED','PAID'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            //$table->foreign('user_id')->references('id')->on('users');
        });
        DB::statement('ALTER TABLE loans ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

        Schema::create('scheduled_loan_repayments', function (Blueprint $table) {
            $table->id('seq_id');
            $table->uuid('id');
            $table->uuid('loan_id')->index();
            $table->decimal('amount',10,2)->default(0);
            $table->timestamp('payment_date');
            $table->enum('status',['PENDING','PAID'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            //$table->foreign('loan_id')->references('id')->on('loans');
        });
        DB::statement('ALTER TABLE scheduled_loan_repayments ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('scheduled_loan_repayments');
    }
}

