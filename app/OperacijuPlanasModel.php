<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

class OperacijuPlanasModel extends Model
{
    protected $table = 'OperacijuPlanas';
    protected $fillable =['name','details','start', 'end', 'color', 'day'];
    protected $connection = 'phpMyAdminNew';
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
