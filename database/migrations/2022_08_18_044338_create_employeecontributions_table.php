<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 120);
            $table->double('employee_contribution', 10,2);
            $table->double('employer_contribution', 10,2);
            $table->double('employee_gained', 10,2);
            $table->date('date_of_contribution');
            $table->string('uploaded_by', 120);
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
        Schema::dropIfExists('employee_contributions');
    }
}
