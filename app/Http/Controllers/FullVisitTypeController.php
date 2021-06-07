<?php


namespace App\Http\Controllers;
use App\FullVisitTypeModel;
use Illuminate\Http\Request;

class FullVisitTypeController extends Controller
{
    public function index(){
        $Information[] = $_GET;
        $Info = FullVisitTypeModel::where('fullvisitid',$Information[0]['fullvisitid'])
            ->select('*')->get();
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
        FullVisitTypeModel::create($request->all());
    }


    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        FullVisitTypeModel::where('id', $request->input('id'))
            ->update([
                'VERSION' => $request->input('VERSION')
            ]);
    }


    public function destroy($id){

        FullVisitTypeModel::where('id', $id)->delete();

    }



}
