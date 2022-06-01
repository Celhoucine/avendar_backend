<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agences', function (Blueprint $table) {
            $table->bigInteger('id',false,true)->unique();
            $table->string('email',255);
            $table->string('agenceName',255);
            $table->string('address',255);
            $table->Integer('phone');
            $table->string('verified',255)->default('suspended');
            $table->timestamps();
            $table->foreign('email')->references('email')->on('users');
            $table->primary(array('email'));




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agences');
    }
}
