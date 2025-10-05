<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsAccountInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings_account_infos', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique(); // Foreign key
            $table->string('account_number')->unique();
            $table->string('account_type')->default('savings');
            // $table->string('amount')->default('500');
            $table->bigInteger('amount')->default(500);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('member_code')->references('member_code')->on('customer_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savings_account_infos');
    }
}
