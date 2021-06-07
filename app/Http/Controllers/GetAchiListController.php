<?php

namespace App\Http\Controllers;

use App\F025InfoCardIntervations;

class GetAchiListController extends Controller
{

    public function index()
    {
        $Str= implode("",$_GET);
        $DiagnosisList = F025InfoCardIntervations::where('ACHI_KODAS','like',"%$Str%")->orWhere('TITLE','like',"%$Str%")->select('CODE','TITLE')->get();
        return $DiagnosisList;
    }

}
