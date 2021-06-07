<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use GuzzleHttp\HandlerStack;
use Guzzle\Http\Exception\BadResponseException;
use App\OperationCodes;
use App\SinglePack;
use function Sodium\crypto_box_publickey_from_secretkey;

class SendCode extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check request information
        $request = request();

        //take information from request
        $actionName = $request->actionName;
        $productCode = $request->productCode;
        $expirityDate = $request->expirityDate;
        $serialNumber = $request->serialNumber;
        $batchNumber = $request->batchNumber;

        //need to make authorization
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => 'https://nbsltprod.emvs-nbs.eu:8637/connect/token',
            //            'base_uri' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
        ]);
        $reauth_config = [
            "client_id" => "f6706814-4be5-41e3-813b-9d73f7855776",
            "client_secret" => "c9c4c939-cb5b-48ca-a3af-6d2655e22f30",
//            "grant_type" => "device_id",
            //            "client_id" => "Klaipeda University Hospital",
            //            "client_secret" => "cd8c16d5f0b24f4eaa979829eb24397b",
            //            "scope" => "your scope(s)", // optional
            //            "state" => time(), // optional
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);

        $stack = HandlerStack::create();
        $stack->push($oauth);

// This is the normal Guzzle client that you use in your application
        $client = new \GuzzleHttp\Client([
            'handler' => $stack,
            'auth'    => 'oauth',
            'headers' => [
                'emvs-data-entry-mode' => 'non-manual',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
        $url = 'https://nbsltprod.emvs-nbs.eu:8978/product/gs1/'.$productCode.'/pack/'.$serialNumber.'?batch='.$batchNumber.'&expiry='.$expirityDate;
//        $url = 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api/product/gs1/'.$productCode.'/pack/'.$serialNumber.'?batch='.$batchNumber.'&expiry='.$expirityDate;
        $responseFull = "";
        try {
           $response = $client->get($url);
            $operationHttpCode = $response->getStatusCode();
           $responseFull = $response->getBody()->getContents();
            $resultOperationCode= json_decode($responseFull)->operationCode;
        }

        catch (\GuzzleHttp\Exception\ClientException $e) {
            $operationHttpCode = $e->getResponse()->getStatusCode();
//            if ( in_array ($errorCode,['404'])) {
                $responseFull =  $e->getResponse()->getBody()->getContents();
            $resultOperationCode= json_decode($responseFull)->operationCode;
            $responseFullDecoded = json_decode($responseFull);
//            }
//            else{
//                    echo 'nieko gero';
//                }
            }
            $insertableValues = ['action'=>$actionName,'productcode'=>$productCode,'expiritydate'=>$expirityDate,'serialnumber'=>$serialNumber,'batchnumber'=>$batchNumber,
                                 'resultoperationhttpcode'=>$operationHttpCode,'resultoperationcode'=>$resultOperationCode];

        SinglePack::create($insertableValues);
        try {
            $responseForVerify =  OperationCodes::where('operationcode', $resultOperationCode)->first();
            if($responseForVerify){
                $responseLastOne['data'] = $responseForVerify;
                $responseLastOne['statusQuery'] = 'YES';
                return $responseLastOne;
            }
            else{
                $responseLastOne['data'] = $responseFullDecoded;
                $responseLastOne['statusQuery'] = 'NO';
                return $responseLastOne;
            }
        } catch (ErrorException $e) {
            return $responseFull;
        }
//        return OperationCodes::where('oper')
        //echo "Status: ".$response->getStatusCode()."\n";
//        $responseFull = $response->getBody()->getContents()->response;
//        //echo gettype($responseFull);
//        echo(json_decode($responseFull)->operationCode);
//        return response()->json($responseFull);
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
