<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetApBrigadaController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $ApBrigada = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('ATVEZE_GMP')->first()->ATVEZE_GMP;

        return $ApBrigada;

    }
}