<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OperationsCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OperationCodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('httpstatuscode');
            $table->string('apioperation');
            $table->string('infotype');
            $table->string('packstate');
            $table->string('reasondisambiguator');
            $table->string('isalert');
            $table->string('operationcode');
            $table->string('displaytext');
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
        Schema::dropIfExists('OperationCodes');
    }
}
