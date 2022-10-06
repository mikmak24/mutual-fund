<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class MasterValueHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_value_history', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount', 10,5);
            $table->date('date_of_change');
            $table->string('changed_by', 120);
            $table->float('difference')->nullable();
            $table->float('percentage')->nullable();
            $table->string('status', 60)->nullable();
            $table->timestamps();
        });

        DB::table('master_value_history')->insert([
            [
                'amount' => 1, 
                'date_of_change' => date('Y-m-d'),
                'changed_by' => 'Initial Value',
                'difference' => 0,
                'percentage' => 0,
                'status' => 'increases',
        ],
          
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_value_history');
    }
}
