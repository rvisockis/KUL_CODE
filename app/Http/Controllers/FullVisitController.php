<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FullVisitModel;
use Illuminate\Http\Response;

class FullVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Information[]= $_GET ;
        $Info = FullVisitModel::where('fullinfoid',$Information[0]["fullinfoid"])
            ->where('KORTELES_NR',$Information[0]["KORTELES_NR"])
            ->select('*')->get();
        return $Info;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        FullVisitModel::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        FullVisitModel::where('fullinfoid', $request->input('fullinfoid'))
            ->where('EIL_NR',$request->input('EIL_NR'))
            ->update([
                'APAP_ID'=> $request->input('APAP_ID'),
                'APSILANKYMO_DATA'=> $request->input('APSILANKYMO_DATA'),
                'SIUNTIMAS'=> $request->input('SIUNTIMAS'),
                'PASLAUGOS_KODAS'=> $request->input('PASLAUGOS_KODAS'),
                'PASLAUGOS_KODAS_TIKSL'=> $request->input('PASLAUGOS_KODAS_TIKSL'),
                'LIGOS_KODAS'=> $request->input('LIGOS_KODAS'),
                'PASLAUGOS_TIPAS1'=> $request->input('PASLAUGOS_TIPAS1'),
                'SPECIALISTAS_SP'=> $request->input('SPECIALISTAS_SP'),
                'KORTELES_NR'=> $request->input('KORTELES_NR'),
                'HIS_ID'=> $request->input('HIS_ID'),
                'KAINA_BALAIS'=> $request->input('KAINA_BALAIS'),
                'KAINA'=> $request->input('KAINA'),
                'VALIUTA'=> $request->input('VALIUTA'),
                'MOKAMA_IS_PSDF'=> $request->input('MOKAMA_IS_PSDF'),
                'EIL_NR_UI'=> $request->input('EIL_NR_UI'),
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FullVisitModel::where('id', $id)->delete();
    }
}
