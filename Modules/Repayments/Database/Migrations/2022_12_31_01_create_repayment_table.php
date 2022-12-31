<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id('seq_id');
            $table->uuid('id');
            $table->uuid('loan_id')->index();
            $table->decimal('loan_amount_paid',10,2);
            $table->decimal('excess_amount_paid',10,2);
            $table->enum('status',['PENDING','SUCCESS','FAILED'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            //$table->foreign('loan_id')->references('id')->on('loans');
        });
        DB::statement('ALTER TABLE repayments ALTER COLUMN id SET DEFAULT uuid_generate_v4();');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repayments');
    }
}

