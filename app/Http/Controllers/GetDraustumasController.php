<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetDraustumasController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $Draustumas = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('DRAUSTUMAS')->first()->DRAUSTUMAS;

        return $Draustumas;

    }
}