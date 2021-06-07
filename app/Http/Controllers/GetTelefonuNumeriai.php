<?php


namespace App\Http\Controllers;

use App\TelefonuNumeriai;
class GetTelefonuNumeriai extends Controller
{
    public function index(){
//        $getas[] = $_GET;
        $Tel_nr = TelefonuNumeriai::select('*')->get();

        return $Tel_nr;

    }
}
