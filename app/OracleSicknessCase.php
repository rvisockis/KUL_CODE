<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OracleLivingSubject;
use App\OracleVisit;
use App\Traits\FilterPaginateOrder;
use App\OracleLivingSubjectLink;
use App\OracleStructureUnit;
use App\OracleOrganization;



class OracleSicknessCase extends Model
{
    use FilterPaginateOrder;

    protected $table='SICKNESS_CASE';
    protected $connection='oracle';
    protected $primaryKey='id';
    //protected $visible = ['case_number','person_link_id', 'days_in_hospital','structure_unit_id'];
//   public $with = ['sicknessCaseWithVisit1'];
    // whitelist of filter-able columns
    protected $filter = [
        'case_number','full_name','start_date','days_in_hospital','ward_name'
    ];

    public function sicknessCaseWithLivingSubject()
    {
        return $this->belongsTo('App\OracleLivingSubject', 'person_link_id')->select('id');
    }

    public function sicknessCaseWithVisit()
    {
//        return $this->hasMany('App\OracleVisit', 'sickness_case_id','id');
        return $this->hasMany('App\OracleVisit', 'sickness_case_id','id')->select(['sickness_case_id', 'structure_unit_id']);
    }
}
