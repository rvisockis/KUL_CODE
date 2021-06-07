<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetApSiuntimasController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $ApSiuntimas = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('ATVYKO_PAGAL_SIUNTIMA')->first()->ATVYKO_PAGAL_SIUNTIMA;

        return $ApSiuntimas;

    }
}