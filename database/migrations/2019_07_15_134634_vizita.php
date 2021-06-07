<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vizita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullinfoid',2000);
            $table->string('APSILANKYMO_DATA',30);
            $table->string('SIUNTIMAS',20);
            $table->string('PASLAUGOS_KODAS',10);
            $table->string('PASLAUGOS_KODAS_TIKSL',20);
            $table->string('LIGOS_KODAS',6);
            $table->string('PASLAUGOS_TIPAS1',20);
            $table->string('SPECIALISTAS_SP',20);
            $table->string('KORTELES_NR',20);
            $table->string('HIS_ID',20);
            $table->string('KAINA_BALAIS',20);
            $table->string('KAINA',20);
            $table->string('VALIUTA',20);
            $table->string('MOKAMA_IS_PSDF',10);
            $table->string('EIL_NR',10);
            $table->string('EIL_NR_UI',10);
            $table->string('APAP_ID',20);
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
