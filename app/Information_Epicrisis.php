<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information_Epicrisis extends Model
{
    protected $table ='information__epicrises';
    protected $fillable =['VISITID','ANAMNEZE','APZIUROS_REZULTATAI','TYRIMU_PLANAS','LIGOS_EIGA','GYDYMO_REKOMENDACIJOS'];
    protected $connection = 'phpMyAdmin';
}
