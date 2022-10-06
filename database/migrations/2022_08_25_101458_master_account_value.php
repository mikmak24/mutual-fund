<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class MasterAccountValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->double('master_account_amount', 10,5);
            $table->timestamps();
        });

        DB::table('master_accounts')->insert([
            [
                'master_account_amount' => 1,
                
            ]]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_accounts');
    }
}
