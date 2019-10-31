<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('name', 250)->default('');
            $table->string('slug')->default('')->unique();
            $table->string('feed')->unique()->default('');
            $table->string('web', 250)->default('');
            $table->string('language', 2)->default('');
            $table->string('image', 50)->default('');
            $table->text('description')->nullable();
            $table->bigInteger('categories_id')->unsigned()->default(1);
            //$table->foreign('category')->references('id')->on('categories');
            $table->bigInteger('author')->unsigned()->default(0);
            //$table->foreign('author')->references('id')->on('authors');
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
        Schema::dropIfExists('shows');
    }
}
