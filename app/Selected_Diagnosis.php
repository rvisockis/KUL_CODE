<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selected_Diagnosis extends Model
{
    protected $table = 'selected__diagnoses';
    protected $fillable = ['Visitid', 'DiagnosisCode','DiagnosisType','DiagnosisTime','DiagnosisName','ClinicalName','DoctorID'];
    protected $connection='phpMyAdmin';
}
