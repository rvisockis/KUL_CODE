<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnosisCacheModel extends Model
{
    protected $table ='diagnosis_cache_models';
    protected $fillable =['diagnosis','PC','doctorID','Username','type','time','VISITID','ClinicalName'];
    protected $connection = 'phpMyAdmin';
}
