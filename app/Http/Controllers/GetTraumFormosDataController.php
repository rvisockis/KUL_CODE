<?php


namespace App\Http\Controllers;
use App\TraumatologineForma;
use Illuminate\Http\Request;


class GetTraumFormosDataController extends Controller
{

    public function index(){
        $Information[] = $_GET;
        $id = $Information[0]['formid'];
//        print_r($Information[0]['formid']);
        $Info = TraumatologineForma::where('formid',$Information[0]['formid'])
            ->select('*')->get();
//        $Test = $Info->kuno_dalys();
        $Test = TraumatologineForma::find(12)->kuno_dalys;
        echo $Test;
//        $TestRelationship = TraumatologineForma::with('kuno_dalys')->get();
//        echo $TestRelationship;
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
        $id =  TraumatologineForma::create($request->all());
        return ($id->id);
    }

    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        TraumatologineForma::where('formid', $id)
            ->update([
                'formid' => $request->input('formid'),
                'vardas_pavarde' => $request->input('vardas_pavarde'),
                'med_dok_nr' => $request->input('med_dok_nr'),
                'CheckDate' => $request->input('CheckDate'),
                'apziuros_data' => $request->input('apziuros_data'),
                'apziuros_laikas' => $request->input('apziuros_laikas'),
                'but_pagalbos_kat' => $request->input('but_pagalbos_kat'),
                'nusiskundimai' => $request->input('nusiskundimai'),
                'traumos_data' => $request->input('traumos_data'),
                'traumos_laikas' => $request->input('traumos_laikas'),
                'traumos_vieta' => $request->input('traumos_vieta'),
                'traumos_aplinkybes' => $request->input('traumos_aplinkybes'),
                'policija_informuota' => $request->input('policija_informuota'),
                'vaiku_teises' => $request->input('vaiku_teises'),
                'traumuotos_vietos' => $request->input('traumuotos_vietos'),
                'alergija' => $request->input('alergija'),
                'alergija_kam' => $request->input('alergija_kam'),
                'gretutines_ligos' => $request->input('gretutines_ligos'),
                'gretutines_ligos_kokios' => $request->input('med_dok_nr'),
                'bendra_bukle' => $request->input('bendra_bukle'),
                'temperatura' => $request->input('temperatura'),
                'skausmas_balais' => $request->input('skausmas_balais'),
                'oda_gleivines_rausvos' => $request->input('oda_gleivines_rausvos'),
                'oda_gleivines_blyskios' => $request->input('oda_gleivines_blyskios'),
                'pilvas_minkstas' => $request->input('pilvas_minkstas'),
                'pilvas_skausmingas' => $request->input('pilvas_skausmingas'),
                'pilvas_itemptas' => $request->input('pilvas_itemptas'),
                'kvepavimo_daznis' => $request->input('kvepavimo_daznis'),
                'plauciu_auskultacija_k' => $request->input('plauciu_auskultacija_k'),
                'plauciu_auskultacija_d' => $request->input('plauciu_auskultacija_d'),
                'ssd' => $request->input('ssd'),
                'aks' => $request->input('aks'),
                'kpl' => $request->input('kpl'),
                'samones_sutrikimu_nebuvo' => $request->input('samones_sutrikimu_nebuvo'),
                'buvo_be_samones' => $request->input('buvo_be_samones'),
                'buvo_traukuliai' => $request->input('buvo_traukuliai'),
                'pykino_veme' => $request->input('pykino_veme'),
                'kita_anamneze_tekstas' => $request->input('kita_anamneze_tekstas'),
                'samone_gks' => $request->input('samone_gks'),
                'meninginiai_nera' => $request->input('meninginiai_nera'),
                'meninginiai_abejotina' => $request->input('meninginiai_abejotina'),
                'meninginiai_simptomai_tekstas' => $request->input('meninginiai_simptomai_tekstas'),
                'zidinine_simptomatika_nera' => $request->input('zidinine_simptomatika_nera'),
                'zidinine_simptomatika_abejotina' => $request->input('zidinine_simptomatika_abejotina'),
                'zidinine_simptomatika_tekstas' => $request->input('zidinine_simptomatika_tekstas'),
                'nistagmas_nera' => $request->input('nistagmas_nera'),
                'nistagmas_yra_tekstas' => $request->input('nistagmas_yra_tekstas'),
                'rentgenograma' => $request->input('rentgenograma'),
                'rentgenograma_nr' => $request->input('rentgenograma_nr'),
                'rentgenograma_be_pakitimu' => $request->input('rentgenograma_be_pakitimu'),
                'radiniai' => $request->input('radiniai'),
                'tyrimai_radiniai_tekstas' => $request->input('tyrimai_radiniai_tekstas'),
                'bendras_kraujo_tyrimas' => $request->input('bendras_kraujo_tyrimas'),
                'tyrimai_kiti' => $request->input('tyrimai_kiti'),
                'tyrimai_kiti_tekstas' => $request->input('tyrimai_kiti_tekstas'),
                'tlk_10_am' => $request->input('tlk_10_am'),
                'dieta' => $request->input('dieta'),
                'rezimas' => $request->input('rezimas'),
                'nuskausminimas' => $request->input('nuskausminimas'),
                'nuskausminimas_tekstas' => $request->input('nuskausminimas_tekstas'),
                'repozicija' => $request->input('repozicija'),
                'repozicija_tekstas' => $request->input('repozicija_tekstas'),
                'imobilizacija' => $request->input('imobilizacija'),
                'imobilizacija_tekstas' => $request->input('imobilizacija_tekstas'),
                'zaizdos_sutvarkymas' => $request->input('zaizdos_sutvarkymas'),
                'zaizda_susiuta' => $request->input('zaizda_susiuta'),
                'zaizda_suklijuota' => $request->input('zaizda_suklijuota'),
                'zaizda_tvarstis' => $request->input('zaizda_tvarstis'),
                'nudegimo_sutvarkymas' => $request->input('nudegimo_sutvarkymas'),
                'nudegimo_tvarstis' => $request->input('nudegimo_tvarstis'),
                'nudegimo_sutvarkymas_kita' => $request->input('nudegimo_sutvarkymas_kita'),
                'nudegimas_tekstas' => $request->input('nudegimas_tekstas'),
                'gydymas_kita_tekstas' => $request->input('gydymas_kita_tekstas'),
                'imunizacija' => $request->input('imunizacija'),
                'imunizacija_pasiutlige' => $request->input('imunizacija_pasiutlige'),
                'imunizacija_stablige' => $request->input('imunizacija_stablige'),
                'ambulatorinis_gydymas' => $request->input('ambulatorinis_gydymas'),
                'stebejimo_paslauga' => $request->input('stebejimo_paslauga'),
                'stacionarinis_gydymas' => $request->input('stacionarinis_gydymas'),
                'stacionarinis_gydymas_skyriuje' => $request->input('stacionarinis_gydymas_skyriuje'),
                'imobilizacijos_trukme' => $request->input('imobilizacijos_trukme'),
                'rezimas_rekomendacija' => $request->input('rezimas_rekomendacija'),
                'riboti_fizini_kruvi' => $request->input('riboti_fizini_kruvi'),
                'perrisimai' => $request->input('perrisimai'),
                'vakcinacija' => $request->input('vakcinacija'),
                'medikamentai' => $request->input('medikamentai'),
                'kontrole_pas_traumatologa' => $request->input('kontrole_pas_traumatologa'),
                'siuntimas_ortopedinems' => $request->input('siuntimas_ortopedinems'),
                'siuntimas_konsultuoti' => $request->input('siuntimas_konsultuoti'),
                'rekomendacijos_kita' => $request->input('rekomendacijos_kita'),



















































            ]);
    }


    public function destroy($id){

        traum_formos::where('id', $id)->delete();

    }
}
