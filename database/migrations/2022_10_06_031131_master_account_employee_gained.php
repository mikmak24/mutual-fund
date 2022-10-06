<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterAccountEmployeeGained extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_account_employee_gained', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 120);
            $table->float('amount');
            $table->float('amount_total');
            $table->float('percentage')->nullable();
            $table->date('date_of_change');
            $table->string('status', 60)->nullable();
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
        Schema::dropIfExists('master_account_employee_gained');
    }
}
