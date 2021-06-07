<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTraumatologineFormasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traumatologine_forma', function (Blueprint $table) {
            $table->increments('id');
            $table ->text("vardas_pavarde");
            $table ->text("med_dok_nr");
            $table ->text("CheckDate");
            $table ->text("apziuros_data");
            $table ->text("apziuros_laikas");
            $table ->text("but_pagalbos_kat");
            $table ->text("nusiskundimai");
            $table ->text("traumos_data");
            $table ->text("traumos_laikas");
            $table ->text("traumos_vieta");
            $table ->text("traumos_aplinkybes");
            $table ->text("policija_informuota");
            $table ->text("vaiku_teises");
            $table ->text("traumuotos_vietos");
            $table ->text("alergija");
            $table ->text("alergija_kam");
            $table ->text("gretutines_ligos");
            $table ->text("gretutines_ligos_kokios");
            $table ->text("bendra_bukle");
            $table ->text("temperatura");
            $table ->text("skausmas_balais");
            $table ->text("oda_gleivines_rausvos");
            $table ->text("oda_gleivines_blyskios");
            $table ->text("pilvas_minkstas");
            $table ->text("pilvas_skausmingas");
            $table ->text("pilvas_itemptas");
            $table ->text("kvepavimo_daznis");
            $table ->text("plauciu_auskultacija_k");
            $table ->text("plauciu_auskultacija_d");
            $table ->text("ssd");
            $table ->text("aks");
            $table ->text("kpl");
            $table ->text("samones_sutrikimu_nebuvo");
            $table ->text("buvo_be_samones");
            $table ->text("buvo_traukuliai");
            $table ->text("pykino_veme");
            $table ->text("kita_anamneze_tekstas");
            $table ->text("samone_gks");
            $table ->text("meninginiai_nera");
            $table ->text("meninginiai_abejotina");
            $table ->text("meninginiai_simptomai_tekstas");
            $table ->text("zidinine_simptomatika_nera");
            $table ->text("zidinine_simptomatika_abejotina");
            $table ->text("zidinine_simptomatika_tekstas");
            $table ->text("nistagmas_nera");
            $table ->text("nistagmas_yra_tekstas");
            $table ->text("rentgenograma");
            $table ->text("rentgenograma_nr");
            $table ->text("rentgenograma_be_pakitimu");
            $table ->text("radiniai");
            $table ->text("tyrimai_radiniai_tekstas");
            $table ->text("bendras_kraujo_tyrimas");
            $table ->text("tyrimai_kiti");
            $table ->text("tyrimai_kiti_tekstas");
            $table ->text("tlk_10_am");
            $table ->text("dieta");
            $table ->text("rezimas");
            $table ->text("nuskausminimas");
            $table ->text("nuskausminimas_tekstas");
            $table ->text("repozicija");
            $table ->text("repozicija_tekstas");
            $table ->text("imobilizacija");
            $table ->text("imobilizacija_tekstas");
            $table ->text("zaizdos_sutvarkymas");
            $table ->text("zaizda_susiuta");
            $table ->text("zaizda_suklijuota");
            $table ->text("zaizda_tvarstis");
            $table ->text("nudegimo_sutvarkymas");
            $table ->text("nudegimas_tvarstis");
            $table ->text("nudegimo_sutvarkymas_kita");
            $table ->text("nudegimas_tekstas");
            $table ->text("gydymas_kita_tekstas");
            $table ->text("imunizacija");
            $table ->text("imunizacija_pasiutlige");
            $table ->text("imunizacija_stablige");
            $table ->text("ambulatorinis_gydymas");
            $table ->text("stebejimo_paslauga");
            $table ->text("stacionarinis_gydymas");
            $table ->text("stacionarinis_gydymas_skyriuje");
            $table ->text("imobilizacijos_trukme");
            $table ->text("rezimas_rekomendacija");
            $table ->text("riboti_fizini_kruvi");
            $table ->text("perrisimai");
            $table ->text("vakcinacija");
            $table ->text("medikamentai");
            $table ->text("kontrole_pas_traumatologa");
            $table ->text("siuntimas_ortopedinems");
            $table ->text("siuntimas_konsultuoti");
            $table ->text("rekomendacijos_kita");
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
        Schema::dropIfExists('traumatologine_formas');
    }
}
