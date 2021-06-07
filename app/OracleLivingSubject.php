<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OracleVisit;
use App\OracleSicknessCase;
use App\Traits\FilterPaginateOrder;

class OracleLivingSubject extends Model
{
    use FilterPaginateOrder;
    protected $table = 'LIVING_SUBJECT';
    protected $connection='oracle';
    protected $primaryKey='id';
    //public $with = ['sicknessAndVisit','sickness'];

    // whitelist of filter-able columns
    protected $filter = [
        'id'
    ];
    public static function initialize()
    {
        return [
            'display_code' =>'', 'display_name' => '', 'birth_time' => '', 'sickness_and_visit.structure_unit_id' => ''
        ];
    }
        public function sicknessAndVisit()
    {
        return $this->hasManyThrough('App\OracleVisit', 'App\OracleSicknessCase', 'person_link_id', 'sickness_case_id')->select('structure_unit_id');
    }
    public function sickness()
    {
        return $this->hasMany('App\OracleSicknessCase', 'person_link_id','id');
    }
    public function visit()
    {
        return $this->hasManyThrough('OracleVisit', 'OracleSicknessCase', 'PERSON_LINK_ID', 'SICKNESS_CASE_ID');
    }
    public function livingSubjectWithLivingSubjecLink()
    {
        return $this->hasOne('App\OracleLivingSubjectLink', 'living_subject_id')->select(['living_subject_id','correct_living_subject_id']);
    }
}
