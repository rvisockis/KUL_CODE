<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OracleOrganization extends Model
{
    protected $table = 'ORGANIZATION';
    protected $connection='oracle';
    protected $primaryKey='id';



}
