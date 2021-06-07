<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraumatologineFormaESPBI extends Model
{
    protected $table ='traumatologine_forma_e_s_p_b_is';
    protected $fillable=['ESPBI_bukles_ivertinimas','ESPBI_anamneze','ESPBI_alergijos','ESPBI_atliktu_tyrimu_informacija','ESPBI_diagnozes','ESPBI_taikytas_gydymas','ESPBI_rekomendacijos','ESPBI_skiriami_vaistai'];
    protected $connection = 'phpMyAdmin';
}
