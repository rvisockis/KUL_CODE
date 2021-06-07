<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use JasperPHP\JasperPHP as JasperPHP;

class GenerationRadiologyPatientListInPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        $dateFrom = $request->dateGenerateFrom;
        $dateTo = $request->dateGenerateTo;
        $selectedAmb = $request->selectedNotAmb;
//        $pathToFile =  base_path() .  '/vendor/cossou/jasperphp/examples/jonas';
  $pathToFile =  base_path() .  '/vendor/cossou/jasperphp/examples/'.$dateFrom;
        $headers = [
            'Content-Type'=> 'application/pdf',
        ];
        //echo $dateTo;
//        $input = Storage::url('RadiologyList.jasper');
//        $output = Storage::url('public');
//        $jdbc_dir = __DIR__ . '/vendor/geekcom/phpjasper/bin/jaspertarter/jdbc';
//        $options = [
//            'format' => ['pdf'],
//            'locale' => 'en',
//            'params' => [
//                'DateFrom1' =>'2019-01-25',
//                'DateTo1' =>'2019-01-26',
//                'Ambulatory' =>'AMBUL3',
//            ],
//            'db_connection' => [
//                'driver'         => 'oracle',
//                'username'       => 'KULPROD',
//                'password'       => 'kulWasTheLast111',
//                'db_sid'        =>'KULPRD',
//                'host'          =>'192.168.63.82',
//                'port'          =>'1521',
//                'jdbc_driver' => 'oracle.jdbc.driver.OracleDriver',
//                'jdbc_url' => 'jdbc:oracle:thin:@192.168.63.82:1521',
//                'jdbc_dir' => $jdbc_dir
//        ]];
//        $jasper = new PHPJasper;
//        $jasper->process(
//            $input,
//            $output,
//            $options
//        )->execute();

        $database = [
            'driver' => 'oracle',
            'username' => 'KULPROD',
            'password' => 'kulWasTheLast111',
            'db_sid' =>'KULPRD',
            'host' =>'192.168.63.82',
            'port'=>'1521',
            'jdbc_driver' => 'oracle.jdbc.driver.OracleDriver',
            'jdbc_url' => 'jdbc:oracle:thin:@192.168.63.82:1521'
        ];

        $jasper = new JasperPHP;

        // Compile a JRXML to Jasper
//        $jasper->compile(base_path() .  '/vendor/cossou/jasperphp/examples/RadiologyList.jrxml')->execute();

//        dd( $jasper->compile(base_path() .  '/vendor/cossou/jasperphp/examples/RadiologyList.jrxml'));
//        // Process a Jasper file to PDF and RTF (you can use directly the .jrxml)
        $jasper->process(
            base_path() .  '/vendor/cossou/jasperphp/examples/RadiologyList.jasper',
            $pathToFile,
            array("pdf"),
            array('DateFrom1'=>$dateFrom,'DateTo1'=>$dateTo, 'Ambulatory'=>$selectedAmb),
            $database
        )->execute();
//        dd( $jasper->process(
//            __DIR__ . '/../../vendor/cossou/jasperphp/examples/RadiologyList.jasper',
//            __DIR__ . '/../../vendor/cossou/jasperphp/examples/RadiologyList.pdf',
//            array("pdf"),
//            array('php_version' => phpversion(),'DateFrom1'=>'2019-01-29','DateTo1'=>'2019-01-28', 'Ambulatory'=>'AMBUL3'),
//            $database
//        ));
//        $output = $jasper->list_parameters(
//            base_path('/vendor/cossou/jasperphp/examples/RadiologyList.jasper')
//        )->execute();

//        foreach($output as $parameter_description)
//            echo $parameter_description;
//        // List the parameters from a Jasper file.
//        $array = $jasper->list_parameters(
//            __DIR__ . '/../../vendor/cossou/jasperphp/examples/RadiologyList.jasper'
//        )->execute();
//        dd($array);
        //dd($dateInformation);
//        $response = Response::download($pathToFile.'.pdf','jonas.pdf' , $headers);
//        ob_end_clean();
//        return $response;
        return response()->download($pathToFile.'.pdf',$dateFrom.'.pdf' , $headers)->deleteFileAfterSend(true);;
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
