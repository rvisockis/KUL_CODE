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

class CheckBulkPackAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
        ]);
        $reauth_config = [
            "client_id" => "Klaipeda University Hospital",
            "client_secret" => "cd8c16d5f0b24f4eaa979829eb24397b",
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
                'emvs-data-entry-mode' => 'non-manual'
            ],

        ]);
        $url = 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api/Product/packs/33a32625-2361-407b-9244-87d73afc29c9';
        $responseFull = "";
        try {
            $response = $client->get($url);
            $operationHttpCode = $response->getStatusCode();
            $responseFull = $response->getBody()->getContents();
            return $responseFull;
        }

        catch (\GuzzleHttp\Exception\ClientException $e) {
            $operationHttpCode = $e->getResponse()->getStatusCode();
            $responseFull =  $e->getResponse()->getBody()->getContents();
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
