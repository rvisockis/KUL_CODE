<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTestTypes extends Model
{
    protected $connection = 'phpMyAdmin';
    protected $table ='lab_test_types';
    protected $primaryKey= 'id';

    public function GetWhatToTest(){
       return $this -> hasMany('App\LabWhatToTest', 'TestTypeID','id');
    }
    public function test(){
//        return $this ->hasManyThrough('App\LabWhatToTest','App\LabTestsNames','TestTypeID','WhatToTestID','id','');
    }
}
