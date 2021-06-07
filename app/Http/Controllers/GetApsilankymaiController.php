<?php


namespace App\Http\Controllers;

use App\F025InfoCardVisits;
class GetApsilankymaiController extends Controller
{
    public function index(){
        $Visits = F025InfoCardVisits::where('fullinfoid', '=', $_GET)->select('*')->get();
        return $Visits;
    }
}