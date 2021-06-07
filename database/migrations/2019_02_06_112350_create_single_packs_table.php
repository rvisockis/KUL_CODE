<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSinglePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->string('productcode');
            $table->string('expiritydate');
            $table->string('serialnumber');
            $table->string('batchnumber');
            $table->string('resultoperationhttpcode');
            $table->string('resultoperationcode');
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
        Schema::dropIfExists('single_packs');
    }
}
