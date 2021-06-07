<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EpicrisisCacheModel;

class EpicrisisCacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Information[]= $_GET ;
        $ID = EpicrisisCacheModel::where('Username',$Information[0]["Username"])
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
        EpicrisisCacheModel::create($request->all());
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
//        $Information[]= $_GET ;
//        EpicrisisCacheModel::where('id',$Information[0]['id'])->update([$Information[0]['ka']=>$Information[0]['kuom']]);
//        EpicrisisCacheModel::where('id',$id)->update([$Information[0]['ka']=>$Information[0]['kuom']]);
        EpicrisisCacheModel::where('id', $request->input('id'))
            ->update([
                'ANAMNEZE'=> $request->input('anamneze'),
                'APZIUROS_REZULTATAI'=> $request->input('Apziuros'),
                'TYRIMU_PLANAS'=> $request->input('Tyrimo'),
                'LIGOS_EIGA'=> $request->input('Ligos'),
                'GYDYMO_REKOMENDACIJOS'=> $request->input('Rekomendacijos'),
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
