<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DiagnosisSelected extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selected__diagnoses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Visitid');
            $table->string('DiagnosisCode');
            $table->string('DiagnosisType');
            $table->string('DiagnosisTime');
            $table->string('DiagnosisName');
            $table->string('ClinicalName');
            $table->string('DoctorID');
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
