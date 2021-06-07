<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalPostings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_posting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Sending',10);
            $table->string('PC',10);
            $table->string('Name',10);
            $table->string('diagnosis',2000);
            $table->string('speciality',2000);
            $table->string('reason',2000);
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
        //
    }
}
