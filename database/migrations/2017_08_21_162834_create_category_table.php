<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('title', 50);
            $table->string('seo_title', 80)->nullable();
            $table->string('seo_keywords', 100)->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->enum('is_show', ['T', 'F'])->default('T');
            $table->timestamps();
        });

        Schema::create('article', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title', 150)->index();
            $table->string('keywords', 180)->nullable();
            $table->string('description', 355)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('article_data', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('article_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('article')->onDelete('cascade');
            $table->text('content');
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
        Schema::dropIfExists('article_data');
        Schema::dropIfExists('article');
        Schema::dropIfExists('category');
    }
}
