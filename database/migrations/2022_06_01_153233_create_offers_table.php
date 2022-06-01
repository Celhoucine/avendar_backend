<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('agences_id');
            $table->bigInteger('categories_id',false,true);
            $table->string('description',255);
            $table->double('surface');
            $table->integer('prix');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('baladiya');
            $table->string('willaya');
            $table->integer('bathroom');
            $table->integer('garage');
            $table->integer('bedroom');
            $table->integer('livingroom');
            $table->integer('kitchen');
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->foreign('agences_id')->references('email')->on('agences');
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
        Schema::dropIfExists('offers');
    }
}
