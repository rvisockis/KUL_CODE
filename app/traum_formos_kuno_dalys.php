<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class traum_formos_kuno_dalys extends Model
{
    protected $table = 'traum_formos_kuno_dalys';
    protected $fillable = ['formos_id', 'kuno_dalis', 'trauma'];
    protected $connection = 'phpMyAdmin';
}
