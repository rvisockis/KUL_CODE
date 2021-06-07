<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelefonuNumeriai extends Model
{
    protected $table = 'telefonu_numeriai';
//    protected $fillable = ['asmens_kodas', 'busena', 'ligos_atvejo_nr'];
    protected $connection = 'phpMyAdminNew';
}
