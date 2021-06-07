<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendedRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sended_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('PersonID',11);
            $table->string('LabTestName',2000);
            $table->string('LabTestType',2000);
            $table->string('DoctorRequested',2000);
            $table->string('StructureUnit',10);
            $table->string('SicnasseCode',10);
            $table->string('State',120);
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
        Schema::dropIfExists('sended_requests');
    }
}
