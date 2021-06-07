<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OracleStructureUnit;

class OracleVisit extends Model
{
    protected $table='VISIT';
    protected $connection='oracle';
    protected $primaryKey='id';

    public function sicknessCaseAndVisit()
    {
        return $this->belongsTo('App\OracleSicknessCase', 'SICKNESS_CASE_ID')->select('display_name');
//        return $this->belongsTo('OracleLivingSubject', 'PERSON_LINK_ID')->select('display_name');
    }
    public function visitWithStructureUnit()
    {
        return $this->belongsTo('App\OracleStructureUnit', 'structure_unit_id', 'id')->select(['id','sickness_case_id']);
//        return $this->belongsTo('OracleLivingSubject', 'PERSON_LINK_ID')->select('display_name');
    }
}
