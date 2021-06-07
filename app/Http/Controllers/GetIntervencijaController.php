<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\F025InfoCardIntervations;
class GetIntervencijaController extends Controller
{
    public function index(){
        $Intervencija = F025InfoCardIntervations::where('fullvisitid', '=', $_GET)->select('*')->get();
        return $Intervencija;

    }

    public function update(Request $request, $id){
        F025InfoCardIntervations::where('id', $request->input('id'))
            ->update([
                'VERSION' => $request->input('VERSION')
            ]);
    }

    public function store(Request $request){
        F025InfoCardIntervations::create($request->all());
    }
}
