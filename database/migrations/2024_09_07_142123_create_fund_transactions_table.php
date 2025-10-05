<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sender_account_number');    // foreign key
            $table->string('receiver_account_number'); 
            $table->bigInteger('amount');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('sender_account_number')->references('account_number')->on('savings_account_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_transactions');
    }
}
