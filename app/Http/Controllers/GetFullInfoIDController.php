<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetFullInfoIDController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $FullInfoId = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('ID')->first()->ID;

        return $FullInfoId;

    }
}