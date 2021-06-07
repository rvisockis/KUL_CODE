<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaslaugosList extends Model
{
    protected $table = 'f025mokamospaslaugos';
    protected $connection='phpMyAdminNew';
    protected $fillable =['KODAS','PAVADINIMAS', 'KAINA', 'GALIOJIMO_PRADZIA', 'GALIOJIMO_PABAIGA'];
    const CREATED_AT = 'RECORDCREATED';
    const UPDATED_AT = 'RECORDUPDATED';
}
