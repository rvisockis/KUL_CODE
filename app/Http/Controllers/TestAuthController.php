<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\Signer\AccessToken\SignerInterface;
use kamermans\OAuth2\OAuth2Middleware;
use GuzzleHttp\HandlerStack;
//use function Sodium\crypto_box_publickey_from_secretkey;

class TestAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Testing AUTH2.0 client

// Authorization client - this is used to request OAuth access tokens
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => 'https://nbsltiqe1.emvs-nbs.eu:8637/connect/token',
            //'base_uri' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
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
                'Content-type' => 'application/x-www-form-urlencoded',
            ]
        ]);

        $response = $client->get('https://nbsltiqe1.emvs-nbs.eu:8978/product/gs1/05000456013482/pack/0000000100?batch=00001&expiry=201200');
        dd($response);

//        $url = 'https://nbsltiqe1.emvs-nbs.eu:8978/product/gs1/05000456013482/pack/0000000100?batch=00001&expiry=201200';
//
//        $response = $client->get($url);
//
//        //echo "Status: ".$response->getStatusCode()."\n";
//        $responseFull = $response->getBody()->getContents();
//        //echo gettype($responseFull);
//        echo(json_decode($responseFull)->operationCode);

//// Authorization client - this is used to request OAuth access tokens
//        $reauth_client = new \GuzzleHttp\Client([
//            // URL for access_token request
//            'base_url' => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
//        ]);
//        $reauth_config = [
//            "client_id" => "Klaipeda University Hospital",
//            "client_secret" => "cd8c16d5f0b24f4eaa979829eb24397b",
//        ];
//        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
//        $oauth = new OAuth2Subscriber($grant_type);
//
//// This is the normal Guzzle client that you use in your application
//        $client = new GuzzleHttp\Client([
//            'auth' => 'oauth',
//        ]);
//        $client->getEmitter()->attach($oauth);
////        $response = $client->get('http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api/product/gs1/05000456013482/pack/0000000100?batch=00001&expiry=201200');
////
//        echo "Status: ".$response->getStatusCode()."\n";
    }

}
