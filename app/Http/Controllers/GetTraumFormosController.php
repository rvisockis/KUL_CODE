<?php


namespace App\Http\Controllers;
use App\traum_formos;
use Illuminate\Http\Request;

class GetTraumFormosController extends Controller
{
    public function index(){
        $Info = traum_formos::select('*')->get();
        return $Info;
    }


    public function create(){

    }


    public function store(Request $request){
       $id =  traum_formos::create($request->all());
        return ($id->id);
    }


    public function show($id){

    }


    public function edit($id){

    }


    public function update(Request $request, $id){
        traum_formos::where('id', $request->input('id'))
            ->update([
                'asmens_kodas' => $request->input('asmens_kodas'),
                'busena' => $request->input('busena'),
                'ligos_atvejo_nr' => $request->input('ligos_atvejo_nr')
            ]);
    }


    public function destroy($id){

        traum_formos::where('id', $id)->delete();

    }
}
