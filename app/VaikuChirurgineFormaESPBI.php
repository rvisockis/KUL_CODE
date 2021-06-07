<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VaikuChirurgineFormaESPBI extends Model
{
    protected $table ='vaiku_chirurgine_forma_e_s_p_b_is';
    protected $fillable=['Diagnosis','TaikytasGydymoTXT','GydymoRekomendacijosTXT','SpecialistuTXT','AnamnezeTXT','BuklesIvertinimasTXT','AtktiviuTyrimuTXT'];
    protected $connection = 'phpMyAdmin';
}
