<?php


namespace App\Http\Controllers;

use App\F025InfoCardPayments;
use Illuminate\Http\Request;
class GetPriemokaController extends Controller
{
    public function index(){
        $Priemoka = F025InfoCardPayments::where('fullvisitid', '=', $_GET)->select('*')->get();
        return $Priemoka;
    }
    public function update(Request $request, $id){
        F025InfoCardPayments::where('id', $request->input('id'))
            ->update([
                'VERSION' => $request->input('VERSION')
            ]);
    }

    public function store(Request $request){
        F025InfoCardPayments::create($request->all());
    }
}
