<?php


namespace App\Http\Controllers;

use App\OperacijuPlanasModel;
class GetOperacijuPlanasController extends Controller
{
    public function index(){
        $getas[] = $_GET;

        if($getas) {
            $DienosPlanas = OperacijuPlanasModel::where('day', '=', $getas[0]['day'])->select('*')->get();
            return $DienosPlanas;
        } else if (!$getas) {
            $OperacijuPlanas = OperacijuPlanasModel::
        }


    }
}
