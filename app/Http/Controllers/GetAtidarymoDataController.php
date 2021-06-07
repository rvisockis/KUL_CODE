<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetAtidarymoDataController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $AtidarymoData = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('ATIDARYMO_DATA')->first()->ATIDARYMO_DATA;
        $AtidarymoData = explode('T', $AtidarymoData);

        return $AtidarymoData;

    }
}