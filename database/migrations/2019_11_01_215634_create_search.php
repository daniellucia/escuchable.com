<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('search')->nullable();
            $table->string('image', 250)->nullable();
            $table->integer('weight')->default(0);
            $table->string('url', 400)->default('');
            $table->string('type', 20)->default('');
            $table->bigInteger('id_type')->default(0);
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
        Schema::dropIfExists('searches');
    }
}
