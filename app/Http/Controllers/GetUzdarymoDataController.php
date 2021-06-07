<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetUzdarymoDataController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $UzdarymoData = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('UZDARYMO_DATA')->first()->UZDARYMO_DATA;
        $UzdarymoData = explode('T', $UzdarymoData);

        return $UzdarymoData;

    }
}