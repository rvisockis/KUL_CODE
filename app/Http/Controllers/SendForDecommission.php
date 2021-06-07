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

class SendForDecommission extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();
        //take information from request
        $actionName = $request->actionName;
        $productCode = $request->productCode;
        $expirityDate = $request->expirityDate;
        $serialNumber = $request->serialNumber;
        $batchNumber = $request->batchNumber;
        $selectedState = $request->selectedState;


        //need to make authorization
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => 'https://nbsltiqe1.emvs-nbs.eu:8637/connect/token',
//            'base_uri' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
        ]);
        $reauth_config = [
            "client_id" => "5bf84b2d-6433-43eb-8fa7-ed9ed631129a",
            "client_secret" => "ad1ed773-a8c7-4634-a1ea-4540a839cd2a",
//            "client_id" => "Klaipeda University Hospital",
//            "client_secret" => "cd8c16d5f0b24f4eaa979829eb24397b",
            //            "scope" => "your scope(s)", // optional
            //            "state" => time(), // optional
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $resource = '{"state" : "'.$selectedState.'"}';
// This is the normal Guzzle client that you use in your application
        $client = new \GuzzleHttp\Client([
            'handler' => $stack,
            'auth'    => 'oauth',
            'headers' => [
                'emvs-data-entry-mode' => 'non-manual',
                'Content-Type' => 'application/json',
            ],
            'body' => $resource
        ]);
        $url = 'https://nbsltiqe1.emvs-nbs.eu:8978/product/gs1/'.$productCode.'/pack/'.$serialNumber.'?batch='.$batchNumber.'&expiry='.$expirityDate;
//        $url = 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api/product/gs1/'.$productCode.'/pack/'.$serialNumber.'?batch='.$batchNumber.'&expiry='.$expirityDate;
        $responseFull = "";
        try {
            $response = $client->patch($url);
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
