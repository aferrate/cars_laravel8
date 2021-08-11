<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mark');
            $table->string('model');
            $table->text('description');
            $table->string('slug')->unique();
            $table->string('country');
            $table->string('city');
            $table->string('image_filename')->nullable();
            $table->bigInteger('author_id')->unsigned();
            $table->integer('year');
            $table->boolean('enabled');
            $table->timestamps();
            $table->index('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars', function (Blueprint $table) {
            $table->dropForeign('lists_author_id_foreign');
            $table->dropIndex('lists_author_id_index');
            $table->dropColumn('author_id');
        });
    }
}
