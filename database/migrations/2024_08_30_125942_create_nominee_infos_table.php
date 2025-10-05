<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomineeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominee_infos', function (Blueprint $table) {
            $table->string('member_code')->unique(); // Foreign key
            $table->string('nominee_code')->unique()->primary();
            $table->string('nominee_name');
            $table->string('age');
            $table->string('nominee_mobile_number')->nullable();
            $table->string('nid_number');
            $table->string('birth_id');
            $table->string('percentage');
            $table->string('relation_with_member');
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
        Schema::dropIfExists('nominee_infos');
    }
}
