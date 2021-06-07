<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiagnosisCacheModel;

class DiagnosisCacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Information[]= $_GET ;
        $ID = DiagnosisCacheModel::where('Username',$Information[0]["Username"])
            ->where('PC',$Information[0]["pc"])
            ->where('doctorID',$Information[0]["doctorID"])
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
        DiagnosisCacheModel::create($request->all());
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
//
        DiagnosisCacheModel::where('id', $request->input('id'))
            ->update([
                'diagnosis'=> $request->input('Diagnosis'),
                'type'=> $request->input('Type'),
                'time'=> $request->input('Time'),
                'title'=> $request->input('Title'),
                'ClinicalName'=> $request->input('ClinicalName'),

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
