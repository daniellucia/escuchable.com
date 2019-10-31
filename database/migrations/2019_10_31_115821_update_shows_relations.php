<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShowsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shows', function ($table) {
            //$table->integer('category')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories');
        });

        Schema::table('episodes', function ($table) {
            //$table->integer('show')->unsigned();
            $table->foreign('show')->references('id')->on('shows');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shows', function (Blueprint $table) {
            //$table->dropForeign('category_id_foreign');
        });

        Schema::table('episodes', function ($table) {
            //$table->dropForeign('show_id_foreign');
        });
    }
}
