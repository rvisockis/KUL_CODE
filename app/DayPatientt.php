<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayPatientt extends Model
{
    protected $table = 'KUL_PATIENT_VISIT';
    protected $connection='oracle';
}
