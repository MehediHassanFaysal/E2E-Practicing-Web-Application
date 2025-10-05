<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');    // foreign key
            $table->bigInteger('amount');
            $table->string('transaction_type');
            $table->string('transaction_code');
            $table->string('remarks');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('account_number')->references('account_number')->on('savings_account_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_histories');
    }
}
