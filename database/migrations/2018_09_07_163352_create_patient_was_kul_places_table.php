<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientWasKulPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_was_kul_places', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('PACIENTOID')->default(0);
            $table->string('KULVIETOSNUMERIS',500)->default(0);
            $table->string('KULVIETOSPAVADINIMAS',500)->default(0);
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
        Schema::dropIfExists('patient_was_kul_places');
    }
}
