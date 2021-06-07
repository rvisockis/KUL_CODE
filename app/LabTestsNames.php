<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTestsNames extends Model
{
    protected $connection = 'phpMyAdmin';
    protected $table ='lab_tests_names';
    protected $primaryKey= 'id';
    public function GetAnalites(){
        return $this->hasMany('App\LabTestsAnalites','TestNameID','id');
    }
}
