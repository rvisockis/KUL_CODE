<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalPostingModel extends Model
{
    protected $table = 'medical_posting';
    protected $fillable =['SENDING','PERSON_CODE','PATIENT_NAME','POSTING_DIAGNOSIS','REQUIRED_SPECIALITY','REASON','SENDING_COMPANY','SENDING_DOCTOR'];
    protected $connection = 'phpMyAdmin';
}
