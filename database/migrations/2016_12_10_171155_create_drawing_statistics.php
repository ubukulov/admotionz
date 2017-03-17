<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawingStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawing_statistics', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('drawing_id')->unsigned();
            $table->foreign('drawing_id')->references('id')->on('drawing');
            $table->string('ip');
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
        Schema::drop('drawing_statistics');
    }
}
