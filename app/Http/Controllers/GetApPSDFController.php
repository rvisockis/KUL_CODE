<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetApPSDFController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $ApPSDF = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('MOKETINA_IS_PSDF')->first()->MOKETINA_IS_PSDF;

        return $ApPSDF;

    }
}