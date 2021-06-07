<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GetDiagnosisList;
use App\DiagnosisList;

class GetDiagnosisListController extends Controller
{

    public function index()
    {
        $Str= implode("",$_GET);
        $DiagnosisList = DiagnosisList::where('CODE','like',"%$Str%")->orWhere('TITLE','like',"%$Str%")->select('CODE','TITLE')->get();
       return $DiagnosisList;
    }

}
