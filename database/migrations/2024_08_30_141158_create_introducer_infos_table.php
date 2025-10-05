<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroducerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('introducer_infos', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique(); // Foreign key
            $table->string('introducer_account');
            $table->string('introducer_name')->nullable();
            $table->string('introducer_nid')->nullable();
            $table->string('introducer_mobile_number')->nullable();
            $table->string('remaks')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('member_code')->references('member_code')->on('customer_infos')->onDelete('cascade');
            // $table->foreign('member_code')->references('member_code')->on('savings_account_infos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('introducer_infos');
    }
}
