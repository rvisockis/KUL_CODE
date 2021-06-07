<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaikuChirurgineFormaESPBIsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaiku_chirurgine_forma_e_s_p_b_is', function (Blueprint $table) {
            $table->increments('id');
            $table->text("Diagnosis")->nullable();
            $table->text("TaikytasGydymoTXT")->nullable();
            $table->text("GydymoRekomendacijosTXT")->nullable();
            $table->text("SpecialistuTXT")->nullable();
            $table->text("AnamnezeTXT")->nullable();
            $table->text("BuklesIvertinimasTXT")->nullable();
            $table->text("AtktiviuTyrimuTXT")->nullable();
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
        Schema::dropIfExists('vaiku_chirurgine_forma_e_s_p_b_is');
    }
}
