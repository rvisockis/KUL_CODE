<?php

namespace App\Http\Controllers;

use App\PaslaugosList;
use Illuminate\Http\Request;

class GetPaslaugosListPageController extends Controller
{

    public function index()
    {
        $PaslaugosList = PaslaugosList::select('*')->get();
        return $PaslaugosList;
    }

    public function store(Request $request){
        PaslaugosList::create($request->all());
        echo 'store ivykdytas';
    }

    public function update(Request $request, $id){
        PaslaugosList::where('id', $request->input('id'))
            ->update([
                'KODAS' => $request->input('KODAS'),
                'PAVADINIMAS' => $request->input('PAVADINIMAS'),
                'KAINA' => $request->input('KAINA'),
                'GALIOJIMO_PRADZIA' => $request->input('GALIOJIMO_PRADZIA'),
                'GALIOJIMO_PABAIGA' => $request->input('GALIOJIMO_PABAIGA')
            ]);
    }

    public function destroy($id){

        PaslaugosList::where('id', $id)->delete();

    }

}
