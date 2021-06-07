<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OracleOrganization;

class OracleStructureUnit extends Model
{
    protected $table = 'STRUCTURE_UNIT';
    protected $connection='oracle';
    protected $primaryKey='id';

    public function structureUnitWithOrganization()
    {
        return $this->hasOne('App\OracleOrganization','id', 'id')->select(['id', 'display_name']);
    }

}
