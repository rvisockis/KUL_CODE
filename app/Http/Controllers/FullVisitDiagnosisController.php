<?php


namespace App\Http\Controllers;
use App\FullVisitDiagnosisModel;
use Illuminate\Http\Request;

class FullVisitDiagnosisController extends Controller
{

    public function index(){
        $Information[] = $_GET;
        $Info = FullVisitDiagnosisModel::where('fullinfoid',$Information[0]['fullinfoid'])
            ->select('*')->get();
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
        FullVisitDiagnosisModel::create($request->all());
    }


    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        FullVisitDiagnosisModel::where('id', $request->input('id'))
            ->update([
                'DATA' => $request->input('DATA'),
                'LIGOS_KODAS' => $request->input('LIGOS_KODAS'),
                'LIGOS_TIPAS' => $request->input('LIGOS_TIPAS')
            ]);
    }


    public function destroy($id){

        FullVisitDiagnosisModel::where('id', $id)->delete();

    }

}
