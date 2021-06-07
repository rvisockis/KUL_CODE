<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VizituModel extends Model
{
    protected $table ='visits_table';
    protected $fillable =['fullinfoid','APSILANKYMO_DATA','SIUNTIMAS','PASLAUGOS_KODAS','PASLAUGOS_KODAS_TIKSL','LIGOS_KODAS','PASLAUGOS_TIPAS1','SPECIALISTAS_SP','KORTELES_NR','HIS_ID','KAINA_BALAIS','KAINA','VALIUTA','MOKAMA_IS_PSDF','EIL_NR','EIL_NR_UI','APAP_ID'];
    protected $connection = 'phpMyAdmin';
}
