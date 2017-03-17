<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * status
     * 0 - Ждет модерации
     * 1 - Опубликован
     * 2 - Снять с публикации
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status',['0','1','2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
