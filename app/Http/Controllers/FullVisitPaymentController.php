<?php


namespace App\Http\Controllers;
use App\FullVisitPaymentModel;
use Illuminate\Http\Request;

class FullVisitPaymentController extends Controller
{

    public function index(){
        $Information[] = $_GET;
        $Info = FullVisitPaymentModel::where('fullvisitid',$Information[0]['fullvisitid'])
            ->select('*')->get();
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
        FullVisitPaymentModel::create($request->all());
    }


    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        FullVisitPaymentModel::where('fullvisitid', $request->input('fullvisitid'))
            ->update([
                'FINANSAVIMO_SALTINIS' => $request->input('FINANSAVIMO_SALTINIS'),
                'MOKAMOS_PASLAUGOS' => $request->input('MOKAMOS_PASLAUGOS'),
                'MOKAMOS_PASLAUGOS_SKUBIOS' => $request->input('MOKAMOS_PASLAUGOS_SKUBIOS'),
                'MOKAMOS_PASLAUGOS_KITOS' => $request->input('MOKAMOS_PASLAUGOS_KITOS'),
                'PRIEMOKA_MEDZIAGOS ' => $request->input('PRIEMOKA_MEDZIAGOS'),
                'PRIEMOKA_KITA ' => $request->input('PRIEMOKA_KITA')
            ]);
    }


    public function destroy($id){

        FullVisitPaymentModel::where('id', $id)->delete();

    }

}
