<?php

namespace App\Http\Controllers;


use App\PaslaugosList;

class GetPaslaugosListController extends Controller
{

    public function index()
    {
        $Str= implode("",$_GET);
        $PaslaugosList = PaslaugosList::where('KODAS','like',"%$Str%")->orWhere('PAVADINIMAS','like',"%$Str%")->select('KODAS','PAVADINIMAS','KAINA')->get();
        return $PaslaugosList;
    }

}
