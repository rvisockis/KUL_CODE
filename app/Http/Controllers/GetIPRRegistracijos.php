<?php


namespace App\Http\Controllers;
use App\IPRRegistracijos;
class GetIPRRegistracijos extends Controller
{
    public function index(){
        $Info = IPRRegistracijos::where('asmenskodas', $_GET['ak'])->select('*')->get();
        return $Info;

    }
}
