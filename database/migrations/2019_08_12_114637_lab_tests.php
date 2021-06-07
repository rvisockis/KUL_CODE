<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LabTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabTests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TestName',2000);
            $table->string('PatiendPersonalID',2000);
            $table->string('SendingDoctor',2000);
            $table->string('State',2000);
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
