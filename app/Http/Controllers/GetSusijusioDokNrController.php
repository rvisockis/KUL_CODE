<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetSusijusioDokNrController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $Susijusio_Dok_Nr = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('SUSIJUSIO_DOK_NR')->first()->SUSIJUSIO_DOK_NR;

        return $Susijusio_Dok_Nr;

    }
}