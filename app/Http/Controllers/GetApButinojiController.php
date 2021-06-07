<?php


namespace App\Http\Controllers;

use App\F025InfoCard;
class GetApButinojiController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $ApButinoji = F025InfoCard::where('ASMENS_KODAS', '=', $getas[0]['ASMENS_KODAS'])->where('KORTELES_NR', '=', $getas[0]['KORTELES_NR'])->select('BUTINOJI_PAGALBA')->first()->BUTINOJI_PAGALBA;

        return $ApButinoji;

    }
}