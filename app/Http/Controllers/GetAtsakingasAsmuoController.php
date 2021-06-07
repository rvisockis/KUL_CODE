<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetAtsakingasAsmuoController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $AtsakingasAsmuo = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('ATSAKINGAS_ASMUO_AK')->first()->ATSAKINGAS_ASMUO;

        return $AtsakingasAsmuo;

    }
}