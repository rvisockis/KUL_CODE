<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OracleSicknessCase;

class OracleStatRegistration extends Model
{
    protected $table = 'STAT_REGISTRATION';
    protected $connection='oracle';
    protected $primaryKey='id';

    public function registrationAndSicknessCase(){
        return $this->hasOne('OracleSicknessCase','ID','SICKNESS_CASE_ID');
    }
}
