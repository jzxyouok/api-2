<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('parent_id')->unsigned()->default(0);
            $table->string('icon')->nullable();
            $table->string('title');
            $table->string('path');
            $table->string('component');
            $table->tinyInteger('sort')->unsigned()->default(0);
            $table->enum('is_show', ['T', 'F'])->default('T');
        });

        Schema::create('menu_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->integer('menu_id')->unsigned()->index();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_role');
        Schema::dropIfExists('menus');
    }
}
