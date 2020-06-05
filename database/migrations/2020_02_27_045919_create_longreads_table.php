<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLongreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('longreads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default("Some kind of longread");
            $table->string('url')->nullable();
            $table->integer('user_id')->unsigned();
            $table->text('parameters')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('longreads');
    }
}
