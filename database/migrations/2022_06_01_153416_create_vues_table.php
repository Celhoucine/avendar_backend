<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vues', function (Blueprint $table) {
            $table->id();
            $table->string('clients_id',255);
            $table->bigInteger('offers_id',false,true);
            $table->foreign('clients_id')->references('users_id')->on('clients');
            $table->foreign('offers_id')->references('id')->on('offers');
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
        Schema::dropIfExists('vues');
    }
}
