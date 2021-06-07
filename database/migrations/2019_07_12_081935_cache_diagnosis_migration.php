<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CacheDiagnosisMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_cache_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diagnosis',2000);
            $table->string('type',2000);
            $table->string('time',2000);
            $table->string('title',2000);
            $table->string('PC',11);
            $table->string('doctorID',10);
            $table->string('VISITID',10);
            $table->string('Username',10);
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
