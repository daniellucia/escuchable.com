<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150)->default('');
            $table->string('slug', 150)->default('');
            $table->string('unique', 150)->default('')->unique();
            $table->string('link', 250)->default('');
            $table->string('mp3', 250)->default('');
            $table->text('description')->nullable();
            $table->integer('length')->default(0);
            $table->datetime('published')->nullable();
            $table->integer('show')->default(0);
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
        Schema::dropIfExists('episodes');
    }
}
