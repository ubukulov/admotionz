<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->index('id','id_index');
            $table->string('title',255);
            $table->string('keywords',255);
            $table->text('description');
            $table->string('img');
            $table->string('video');
            $table->integer('id_cat',false,true);
            $table->integer('id_advertiser',false,true);
            $table->enum('publish',['1', '0']);
            $table->enum('payment',['0','1']);
            $table->enum('status',['0','1','2']); # 0 = Ждет модерации 1 = Одобрено 2 = Отказано
            $table->integer('deposit')->default(0);
            $table->string('url');
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
        Schema::drop('advertisements');
    }
}
