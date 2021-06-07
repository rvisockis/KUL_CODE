<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalPosting2 extends Migration
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
            $table->string('SENDING',10);
            $table->string('PC',10);
            $table->string('PATIENT_NAME',10);
            $table->string('POSTING_DIAGNOSIS',2000);
            $table->string('REQUIRED_SPECIALITY',2000);
            $table->string('REASON',2000);
            $table->string('SENDING_COMPANY',2000);
            $table->string('SENDING_DOCTOR',2000);
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
