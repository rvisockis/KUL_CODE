<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientCheckIsLive extends Model
{
    protected $primaryKey = 'nativeid';
    protected $table = 'patient_check_is_lives';

    public function patient_check_live_places(){
        return $this->hasMany('App\PatientWasKulPlaces','PACIENTOID');
    }
}
