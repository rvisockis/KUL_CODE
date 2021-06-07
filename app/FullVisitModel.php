<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullVisitModel extends Model
{
    protected $table = 'f025FullInformationCardVisits';
    protected $fillable =['fullinfoid','APSILANKYMO_DATA','SIUNTIMAS','PASLAUGOS_KODAS','PASLAUGOS_KODAS_TIKSL','LIGOS_KODAS','PASLAUGOS_TIPAS1','SPECIALISTAS_SP','KORTELES_NR','HIS_ID','KAINA_BALAIS','KAINA','VALIUTA','MOKAMA_IS_PSDF','EIL_NR','EIL_NR_UI','APAP_ID'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
