<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attDirs', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->integer('parent_id')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('dir_id')->unsigned()->index();
            $table->foreign('dir_id')->references('id')->on('attDirs')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->integer('file_size')->unsigned();
            $table->string('path', 255);
            $table->string('url', 255);
            $table->enum('is_image', ['T', 'F']);
            $table->string('disk')->default('public');
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
        Schema::dropIfExists('attachments');
        Schema::dropIfExists('attDirs');
    }
}
