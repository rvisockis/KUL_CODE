<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabTestData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabTestData', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TestType',2000);
            $table->string('WhatToTest',2000);
            $table->string('Test',2000);
            $table->string('TestAnalite',2000);
            $table->string('MesureUnit',2000);
            $table->string('Answer',2000);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
