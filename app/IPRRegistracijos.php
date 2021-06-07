<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class IPRRegistracijos extends Model
{
    protected $table = 'Registracijos';
    protected $connection='phpMyAdminIPR';
}
