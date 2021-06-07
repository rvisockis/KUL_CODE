<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SelectedDiagnosis extends Migration
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
            $table->timestamps();
            $table->integer('visitdiagnosisid');
            $table->string('diagnosiscode');
            $table->string('diagnosistype');
            $table->string('ClinicalName');
            $table->string('diagnosistime');
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
