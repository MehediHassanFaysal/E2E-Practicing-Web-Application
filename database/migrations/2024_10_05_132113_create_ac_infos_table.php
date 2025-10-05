<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_infos', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('ac_no')->unique(); // Unique account number
            $table->string('branch_code'); // Foreign key to the branch
            $table->text('remarks')->nullable(); // Remarks field
            $table->timestamps(); // Created at and updated at timestamps

            // Optional: Add foreign key constraint
            $table->foreign('branch_code')->references('branch_code')->on('branch_infos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_infos');
    }
}
