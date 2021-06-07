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
use App\BulkPack;
use function Sodium\crypto_box_publickey_from_secretkey;


class SendBulkPack extends Controller
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
        $fullJsonRequest = $request->fullJson;

        //need to make authorization
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
//            'base_uri' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
            'base_uri' => 'https://nbsltiqe1.emvs-nbs.eu:8637/connect/token',
        ]);
        $reauth_config = [
            "client_id" => "5bf84b2d-6433-43eb-8fa7-ed9ed631129a",
            "client_secret" => "ad1ed773-a8c7-4634-a1ea-4540a839cd2a",
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
                'Content-Type' => 'application/json'
            ],
            'body' => $fullJsonRequest,

        ]);
//        $url = 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api/product/packs';
        $url = 'https://nbsltiqe1.emvs-nbs.eu:8978/product/packs';
        $responseFull = "";
        try {
            $response = $client->post($url);
            $operationHttpCode = $response->getStatusCode();
            $responseHeader = $response->getHeader('location');
            $responseContent = $response->getBody()->getContents();
            $resultOperationCode = json_decode($responseContent)->operationCode;
            $resultEta = json_decode($responseContent)->eta;
            $resultExpires = json_decode($responseContent)->expires;
            $operationResultLink = $responseHeader[0];
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
//        return $responseFull;
        $insertableValues = ['action'=>$actionName,
                             'fullJsonQuery'=>addslashes($fullJsonRequest),
                             'resultAnswerLink'=>addslashes($operationResultLink),
                             'resultAnswerExpiry'=>$resultExpires,
                             'resultAnswerOperationCode'=>$resultOperationCode,
                             'resultAnswerHttpCode'=>$operationHttpCode,
                             'resultAnswerEta'=>$resultEta];

        BulkPack::create($insertableValues);



        //Try to get information about bulk packs statuses
        $clientAnswer = new \GuzzleHttp\Client([
            'handler' => $stack,
            'auth'    => 'oauth',
            'headers' => [
                'emvs-data-entry-mode' => 'non-manual'
            ]
        ]);
        $url = $operationResultLink;
        $responseFull = "";
        $responseFullDecoded = "";
        //echo $url;
        sleep(50);
        try {
            $responseAnswer = $clientAnswer->get($url);
            $operationHttpCode = $responseAnswer->getStatusCode();
            $responseFull = $responseAnswer->getBody()->getContents();
            $resultOperationCode = json_decode($responseFull)->operationCode;
            $responseFullDecoded = json_decode($responseFull)->packs;
        }

        catch (\GuzzleHttp\Exception\ClientException $e) {
            $operationHttpCode = $e->getResponse()->getStatusCode();
            $responseFull =  $e->getResponse()->getBody()->getContents();
            $resultOperationCode= json_decode($responseFull)->operationCode;
            $responseFullDecoded = json_decode($responseFull)->packs;
        }
        $responseLastOne = array();
        try {
            $responseForVerify =  OperationCodes::where('operationcode', $resultOperationCode)->first();
            if($responseForVerify){
                $responseLastOne['data'] = $responseForVerify;
                $responseLastOne['statusQuery'] = 'YES';
                foreach($responseFullDecoded as $key=>$responseOneDecoded) {
                    $responseCodeText = OperationCodes::where('operationcode', $responseOneDecoded->result->operationCode)->first();
                    if($responseCodeText) {
                        $responseFullDecoded[$key]->result->information = $responseCodeText->displaytext;
                        $responseFullDecoded[$key]->result->isAlert = $responseCodeText->isalert;
                        $responseFullDecoded[$key]->result->infoType = $responseCodeText->infotype;
                    }
                    else{
                        $responseFullDecoded[$key]->result->isAlert = 'No Information';
                        $responseFullDecoded[$key]->result->infoType = 'No Information';
                    }

                    //echo $responseCodeText->displaytext;

                }
//                $responseLastOne['responsePackInformation'] = $responseFullDecoded;
                $responseLastOne['responseFull'] = $responseFullDecoded;
                return $responseLastOne;
            }
            else{
                $responseLastOne['data'] = $responseFullDecoded;
                $responseLastOne['statusQuery'] = 'NO';
                return $responseLastOne;
            }
        } catch (ErrorException $e) {
//            return $responseFull;
        }

        //----
//        return OperationCodes::where('oper')
        //echo "Status: ".$response->getStatusCode()."\n";
//        $responseFull = $response->getBody()->getContents()->response;
//        //echo gettype($responseFull);
//        echo(json_decode($responseFull)->operationCode);
//        return res
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
