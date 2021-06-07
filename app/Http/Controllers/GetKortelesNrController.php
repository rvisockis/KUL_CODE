<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetKortelesNrController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $Korteles_Nr = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('KORTELES_NR')->first()->KORTELES_NR;

        return $Korteles_Nr;

    }
}