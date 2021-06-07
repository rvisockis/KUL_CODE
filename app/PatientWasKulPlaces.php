<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientWasKulPlaces extends Model
{
    public function patient_check_live(){
        return $this->belongsTo('App\PatientCheckIsLive','PACIENTOID');
    }
}
