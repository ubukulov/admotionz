<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdvertisingCosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_adv');
            $table->integer('id_user');
            $table->integer('id_post');
            $table->integer('paid');
            $table->string('host_name');
            $table->string('country');
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
        Schema::drop('advertising_costs');
    }
}
