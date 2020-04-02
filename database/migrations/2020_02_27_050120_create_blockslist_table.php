<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockslistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockslist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('longread_id')->unsigned();
            $table->integer('block_id')->unsigned();
            $table->json('content');
            $table->json('styles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockslist');
    }
}
