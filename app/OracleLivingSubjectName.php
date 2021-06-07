<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OracleLivingSubjectName extends Model
{
    protected $table = 'LIVING_SUBJECT_NAME';
    protected $connection='oracle';
    protected $primaryKey='id';

    public function sicknessCases()
    {
        return $this->hasManyThrough('OracleSicknessCase', 'OracleLivingSubjectLink', '', 'SICKNESS_CASE_ID');

    }
}
