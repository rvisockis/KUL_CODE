<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class traum_formos extends Model
{
    protected $table = 'traum_formos';
    protected $fillable = ['asmens_kodas', 'busena', 'ligos_atvejo_nr'];
    protected $connection = 'phpMyAdmin';
}
