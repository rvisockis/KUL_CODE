<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabTestsAnalites;
use App\LabTestsNames;
use App\LabTestTypes;
use App\LabWhatToTest;

class LabTestAnaliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = LabTestTypes::with('GetWhatToTest')->get();
        $b =LabWhatToTest::with('GetNames')->get();
        $c =LabTestsNames::with('GetAnalites')->get();
//        $d =LabTestTypes::with('Test')->get();
        // call "get()" to get the results
//        return $user->GetWhatToTest()->get();
//        dd($user);
//        dd($b);
//        echo($c);

//        echo($b);


//        echo($d);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
