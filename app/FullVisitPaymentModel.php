<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
class FullVisitPaymentModel extends Model
{
    protected $table = 'f025FullInformationCardPayments';
    protected $fillable =['fullvisitid','EIL_NR','FINANSAVIMO_SALTINIS', 'MOKAMOS_PASLAUGOS', 'MOKAMOS_PASLAUGOS_SKUBIOS', 'MOKAMOS_PASLAUGOS_KITOS', 'PRIEMOKA_MEDZIAGOS', 'PRIEMOKA_KITA'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
