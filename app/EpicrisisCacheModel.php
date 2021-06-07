<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpicrisisCacheModel extends Model
{
    protected $table ='epicrisis_cache_models';
    protected $fillable =['VISITID','ANAMNEZE','APZIUROS_REZULTATAI','TYRIMU_PLANAS','LIGOS_EIGA','GYDYMO_REKOMENDACIJOS','PC','doctorID','Username'];
    protected $connection = 'phpMyAdmin';
}
