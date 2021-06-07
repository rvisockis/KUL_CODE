<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OracleLivingSubjectLink extends Model
{
    protected $table = 'LIVING_SUBJECT_LINK';
    protected $connection='oracle';
    protected $primaryKey='id';

    public function livingSubjectLinkWithLivingSubjectName()
    {
        return $this->hasOne('App\OracleLivingSubjectName', 'living_subject_id','correct_living_subject_id');
//            ->selectRaw('living_subject_id, first||\' \'||last as full_name');
    }
}
