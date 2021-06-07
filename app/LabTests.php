<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LabTests extends Model
{
    protected $table ='LabTests';
    protected $fillable =['TestName','PatientPersonalID','SendingDoctor','State'];
    protected $connection = 'phpMyAdmin';
}
