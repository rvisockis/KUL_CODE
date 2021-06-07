<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RequestIP extends Controller
{
    public function index(){
        $clientip = request()->ip();
        $hostname = php_uname('a');
        return $clientip;
    }
}
