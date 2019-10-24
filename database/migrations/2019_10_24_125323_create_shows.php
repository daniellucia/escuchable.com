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
            $table->bigIncrements('id');
            $table->string('name', 250)->default('');
            $table->string('slug')->unique()->default('');
            $table->string('feed')->unique()->default('');
            $table->string('web', 250)->default('');
            $table->string('language', 2)->default('');
            $table->string('image', 50)->default('');
            $table->text('description')->nullable();
            $table->integer('category')->default(0);
            $table->integer('author')->default(0);
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
