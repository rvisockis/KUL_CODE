<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraumFormosKunoDalysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traum_formos_kuno_dalys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formos_id');
            $table->text('kuno_dalis');
            $table->text('trauma');
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
        Schema::dropIfExists('traum_formos_kuno_dalys');
    }
}
