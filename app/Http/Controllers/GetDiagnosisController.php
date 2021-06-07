<?php

namespace App\Http\Controllers;

use http\Message;
use Illuminate\Http\Request;
use App\PatientDiagnosis;

class GetDiagnosisController extends Controller
{

    public function index()
    {
        $patientDiagnosis = PatientDiagnosis::where('DISPLAY_CODE', $_GET)->first();
        return $patientDiagnosis;
    }
}
