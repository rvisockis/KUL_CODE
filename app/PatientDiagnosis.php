<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PatientDiagnosis extends Model
{
    protected $table = 'KUL_DIAGNOSIS';
    protected $connection='oracle';

}
