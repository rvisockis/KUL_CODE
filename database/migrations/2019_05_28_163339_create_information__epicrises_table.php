<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationEpicrisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information__epicrises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('VISITID',10); //sarysis su vizitu dar nera aprasyta, bet reikalingas
            $table->string('ANAMNEZE',2000);
            $table->string('APZIUROS_REZULTATAI',2000);  //Apžiūros rezultatai
            $table->string('TYRIMU_PLANAS',2000);  //Tyrimų / konsultacijų plano aprašymas
            $table->string('LIGOS_EIGA',2000);  //Ligos eiga / taikytas gydymas
            $table->string('GYDYMO_REKOMENDACIJOS',2000);  //Gydymo, slaugos, darbo, ambulatorinės priežiūros rekomendacijos (aprašymas)
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
        Schema::dropIfExists('information__epicrises');
    }
}
