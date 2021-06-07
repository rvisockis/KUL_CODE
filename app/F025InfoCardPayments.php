<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
class F025InfoCardPayments extends Model
{
    protected $table = 'f025FullInformationCardPayments';
    protected $connection = 'phpMyAdminNew';
    protected $fillable =['fullvisitid','EIL_NR','FINANSAVIMO_SALTINIS', 'PRIEMOKA_MEDZIAGOS', 'PRIEMOKA_KITA', 'MOKAMOS_PASLAUGOS', 'MOKAMOS_PASLAUGOS_SKUBIOS', 'MOKAMOS_PASLAUGOS_KITOS', 'VERSION', 'PRIEMOKA_MEDZIAGOS', 'PRIEMOKA_KITA'];
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
