<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraumatologineForma extends Model
{
    protected $table ='traumatologine_forma';
    protected $fillable=['formid','vardas_pavarde','med_dok_nr', 'CheckDate', 'apziuros_data','apziuros_laikas','but_pagalbos_kat','nusiskundimai','traumos_data','traumos_laikas','traumos_vieta','traumos_aplinkybes',
        'policija_informuota','vaiku_teises','traumuotos_vietos','alergija',
        'alergija_kam','gretutines_ligos','gretutines_ligos_kokios','bendra_bukle',
        'temperatura','skausmas_balais','oda_gleivines_rausvos','oda_gleivines_blyskios','pilvas_minkstas','pilvas_skausmingas','pilvas_itemptas',
        'kvepavimo_daznis','plauciu_auskultacija_k','plauciu_auskultacija_d','ssd','aks','kpl','samones_sutrikimu_nebuvo','buvo_be_samones',
        'buvo_traukuliai','pykino_veme','kita_anamneze_tekstas','samone_gks','meninginiai_nera',
        'meninginiai_abejotina','meninginiai_simptomai_tekstas','zidinine_simptomatika_nera','zidinine_simptomatika_abejotina','zidinine_simptomatika_tekstas','nistagmas_nera','nistagmas_yra_tekstas',
        'rentgenograma','rentgenograma_nr','rentgenograma_be_pakitimu','radiniai','tyrimai_radiniai_tekstas','bendras_kraujo_tyrimas',
        'tyrimai_kiti','tyrimai_kiti_tekstas','tlk_10_am','dieta','rezimas','nuskausminimas','nuskausminimas_tekstas',
        'repozicija','repozicija_tekstas','imobilizacija','imobilizacija_tekstas','zaizdos_sutvarkymas','zaizda_susiuta','zaizda_suklijuota',
        'zaizda_tvarstis','nudegimo_sutvarkymas','nudegimas_tvarstis','nudegimo_sutvarkymas_kita','nudegimas_tekstas','gydymas_kita_tekstas',
        'imunizacija','imunizacija_pasiutlige','imunizacija_stablige','ambulatorinis_gydymas','stebejimo_paslauga','stacionarinis_gydymas',
        'stacionarinis_gydymas_skyriuje','imobilizacijos_trukme','rezimas_rekomendacija','riboti_fizini_kruvi','perrisimai','vakcinacija',
        'medikamentai','kontrole_pas_traumatologa','siuntimas_ortopedinems','siuntimas_konsultuoti','rekomendacijos_kita'];
    protected $connection = 'phpMyAdmin';

    public function kuno_dalys() {
        return $this->hasMany('App\traum_formos_kuno_dalys', 'formos_id', 'id');
    }
}
