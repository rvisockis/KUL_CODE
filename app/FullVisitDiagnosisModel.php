<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
class FullVisitDiagnosisModel extends Model
{
    protected $table = 'f025FullInformationCardDiagnosis';
    protected $fillable =['fullinfoid','DATA','LIGOS_KODAS', 'LIGOS_TIPAS'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
