<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
class FullVisitTypeModel extends Model
{
    protected $table = 'f025FullInformationCardVisitTypes';
    protected $fillable =['fullvisitid','PASLAUGOS_TIPAS2','VERSION'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
