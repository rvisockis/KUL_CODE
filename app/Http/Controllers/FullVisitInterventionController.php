<?php


namespace App\Http\Controllers;
use App\FullVisitInterventionModel;
use Illuminate\Http\Request;

class FullVisitInterventionController extends Controller
{

    public function index(){
        $Information[] = $_GET;
        $Info = FullVisitInterventionModel::where('fullvisitid',$Information[0]['fullvisitid'])
            ->select('*')->get();
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
        FullVisitInterventionModel::create($request->all());
    }


    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        FullVisitInterventionModel::where('fullvisitid', $request->input('fullvisitid'))
            ->update([
                'ISLAIDOS_KONTR_BALAIS' => $request->input('ISLAIDOS_KONTR_BALAIS'),
                'SPECIALISTAS_SP' => $request->input('SPECIALISTAS_SP'),
                'ACHI_KODAS' => $request->input('ACHI_KODAS')
            ]);
    }


    public function destroy($id){

        FullVisitInterventionModel::where('id', $id)->delete();

    }

}
