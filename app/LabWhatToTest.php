<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabWhatToTest extends Model
{
    protected $connection = 'phpMyAdmin';
    protected $table ='lab_what_to_tests';
    protected $primaryKey= 'id';
    public function GetNames(){
        return $this -> hasMany('App\LabTestsNames', 'WhatToTestID','id');
    }
}
