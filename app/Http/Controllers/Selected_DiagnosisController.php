<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Selected_Diagnosis;

class Selected_DiagnosisController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Information[]= $_GET ;
        $ID = Selected_Diagnosis::where('Visitid',$Information[0]["Visitid"])
            ->select('*')->get();
        return $ID;
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
         Selected_Diagnosis::create($request->all());

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
        //
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
        Selected_Diagnosis::where('id', $id)
            ->update([
                'Visitid'=> $request->input('Visitid'),
                'DiagnosisCode'=> $request->input('DiagnosisCode'),
                'DiagnosisType'=> $request->input('DiagnosisType'),
                'DiagnosisTime'=> $request->input('DiagnosisTime'),
                'DiagnosisName'=> $request->input('DiagnosisName'),
                'ClinicalName'=> $request->input('ClinicalName'),
                'DoctorID'=> $request->input('DoctorID'),

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
        //
    }
}
