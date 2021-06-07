<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientDiagnosis;

class GetDiagnosisHistoryController extends Controller
{

    public function index()
    {
        $patientDiagnosis = PatientDiagnosis::where('DISPLAY_CODE', $_GET)->select('epicrisis_diagnosis_code','sickness_startdate','APPOINTED_DIAGNOSIS_TEXT')->orderBy('SICKNESS_STARTDATE','desc')->take(10)->get();
        return $patientDiagnosis;
    }

}