<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->json('fullJsonQuery');
            $table->string('resultAnswerLink');
            $table->string('resultAnswerExpiry');
            $table->string('resultAnswerOperationCode');
            $table->string('resultAnswerHttpCode');
            $table->string('resultAnswerEta');
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
        Schema::dropIfExists('bulk_packs');
    }
}
