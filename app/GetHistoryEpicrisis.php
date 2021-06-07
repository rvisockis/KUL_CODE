<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GetHistoryEpicrisis extends Model
{
    protected $table = 'KUL_EPICRISIS';
    protected $connection='oracle';
}
