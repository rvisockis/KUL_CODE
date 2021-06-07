<?php


namespace App\Http\Controllers;

use App\F025InfoCardDiagnosis;
class GetF025DiagnosisController extends Controller
{
    public function index(){
        $getas[] = $_GET;
        $Diagnosis = F025InfoCardDiagnosis::where('fullinfoid', '=', $getas[0]['fullinfoid'])->select('*')->get();
//        echo $Diagnosis[0]['id'];
        return $Diagnosis;
    }
}