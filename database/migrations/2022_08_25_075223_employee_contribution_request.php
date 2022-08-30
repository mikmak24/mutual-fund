<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeContributionRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contribution_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 120);
            $table->float('requested_amount');
            $table->string('status', 120);
            $table->date('date_of_request');
            $table->string('approved_by', 120);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_contribution_request');
    }
}
