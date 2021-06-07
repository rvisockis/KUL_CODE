<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
class F025InfoCardIntervations extends Model
{
    protected $table = 'f025FullInformationCardIntervations';
    protected $fillable =['fullvisitid','EIL_NR','ISLAIDOS_KONTR_BALAIS', 'SPECIALISTAS_SP', 'ACHI_KODAS', 'VERSION'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
