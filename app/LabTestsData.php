<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTestsData extends Model
{
    protected $table ='LabTestData';
    protected $fillable =['TestName','TestType','WhatToTest','Test','TestAnalite','Answer','WasChecked','MesureUnit'];
    protected $connection = 'phpMyAdmin';
}
