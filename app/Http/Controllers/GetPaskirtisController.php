<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetPaskirtisController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $Paskirtis = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('PASKIRTIS')->first()->PASKIRTIS;

        return $Paskirtis;

    }
}