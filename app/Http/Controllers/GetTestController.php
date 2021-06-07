<?php


namespace App\Http\Controllers;

use App\Test;
class GetTestController extends Controller
{
    public function index(){
        $asmens_kodas = implode("",$_GET);
//        $Susijusio_Dok_Nr = F025InfoCard::where('KORTELES_NR', 'like', "%$korteles_nr%")->andWhere('ASMENS_KODAS', 'like', "%$asmens_kodas%")->select('SUSIJUSIO_DOK_NR')->take()->get();
//        $Susijusio_Dok_Nr = Test::where('ASMENS_KODAS', 'like', "%$asmens_kodas%")->select('SUSIJUSIO_DOK_NR')->take(1)->get();
        $Susijusio_Dok_Nr = Test::where('nativeid', '=', '1')->select('TITLE')->first()->TITLE;

        return $Susijusio_Dok_Nr;

    }
}
