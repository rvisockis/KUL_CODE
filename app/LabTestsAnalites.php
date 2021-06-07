<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTestsAnalites extends Model
{
    protected $connection = 'phpMyAdmin';
    protected $table ='lab_tests_analites';
    protected $primaryKey= 'id';

}
