<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeContributionHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contribution_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_contribution_id');
            $table->string('username', 120);
            $table->double('employee_contribution', 10,2);
            $table->double('employer_contribution', 10,2);
            $table->double('employee_gained', 10,2);
            $table->boolean('employee_contribution_change');
            $table->boolean('employer_contribution_change');
            $table->string('updated_by', 120);
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
        Schema::dropIfExists('employee_contribution_history');
    }
}
