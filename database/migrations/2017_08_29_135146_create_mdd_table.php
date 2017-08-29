<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdd', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cascader')->default(null);
            $table->integer('loc_id')->unsigned()->index();
            $table->foreign('loc_id')->references('id')->on('loc')->onDelete('cascade');
            $table->string('title', 50);
            $table->string('thumb', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->tinyInteger('sort')->default(0);
            $table->enum('is_show', ['T', 'F'])->default('T');
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
        Schema::dropIfExists('mdd');
    }
}
