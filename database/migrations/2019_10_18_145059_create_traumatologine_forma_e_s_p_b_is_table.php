<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraumatologineFormaESPBIsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traumatologine_forma_e_s_p_b_is', function (Blueprint $table) {
            $table->increments('id');
            $table->text("ESPBI_bukles_ivertinimas")->nullable();
            $table->text("ESPBI_anamneze")->nullable();
            $table->text("ESPBI_alergijos")->nullable();
            $table->text("ESPBI_atliktu_tyrimu_informacija")->nullable();
            $table->text("ESPBI_diagnozes")->nullable();
            $table->text("ESPBI_taikytas_gydymas")->nullable();
            $table->text("ESPBI_rekomendacijos")->nullable();
            $table->text("ESPBI_skiriami_vaistai")->nullable();
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
        Schema::dropIfExists('traumatologine_forma_e_s_p_b_is');
    }
}
