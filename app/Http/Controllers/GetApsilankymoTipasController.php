<?php


namespace App\Http\Controllers;

use App\F025InfoCardVisitTypes;
class GetApsilankymoTipasController extends Controller
{
    public function index(){
        $ApsilankymoTipas = F025InfoCardVisitTypes::where('fullvisitid', '=', $_GET)->select('*')->get();
        return $ApsilankymoTipas;

    }
}
