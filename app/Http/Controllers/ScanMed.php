<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jumbojett\OpenIDConnectClient;


class ScanMed extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//        $oidc = new OpenIDConnectClient('http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000',
//            'Klaipeda University Hospital',
//            'cd8c16d5f0b24f4eaa979829eb24397b');
        $oidc = new OpenIDConnectClient('https://nbsltiqe1.emvs-nbs.eu:8978',
            '662e12b4-afe1-40f7-bbd3-a111855af12d',
            '9b217841-8855-4bc6-a24a-f3add0ab9af8');
        $oidc->providerConfigParam(array('token_endpoint'=>'https://nbsltiqe1.emvs-nbs.eu:8637/connect/token'));
//        $oidc->providerConfigParam(array('token_endpoint'=>'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token'));
        //$oidc->addScope('code');

// this assumes success (to validate check if the access_token property is there and a valid JWT) :
        $clientCredentialsToken = $oidc->requestClientCredentialsToken()->access_token;
        $clientCredentialsToken1 = $oidc->requestClientCredentialsToken()->expires_in;
        $clientCredentialsToken2 = $oidc->requestClientCredentialsToken()->token_type;
        dd($clientCredentialsToken);
//        dd($clientCredentialsToken2);
//        //dd($clientCredentialsToken2);


//        $signer   = new \Lcobucci\JWT\Signer\Rsa\Sha256();
//        $provider = new \OpenIDConnectClient\OpenIDConnectProvider([
//            'clientId'                => 'Klaipeda University Hospital',
//            'clientSecret'            => 'cd8c16d5f0b24f4eaa979829eb24397b',
//            // the issuer of the identity token (id_token) this will be compared with what is returned in the token.
//            'idTokenIssuer'           => '',
//            // Your server
//            'redirectUri'             => 'http://www.kul.lt',
//            'urlAuthorize'            => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000',
//            'urlAccessToken'          => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
//            'urlResourceOwnerDetails' => '',
//            // Find the public key here: https://github.com/bshaffer/oauth2-demo-php/blob/master/data/pubkey.pem
//            // to test against brentertainment.com
//           'publicKey'                 => '',
//        ],
//            [
//                'signer' => $signer
//            ]
//        );
//
//// send the authorization request
//        if (empty($_GET['code'])) {
//            $redirectUrl = $provider->getAuthorizationUrl();
//            header(sprintf('Location: %s', $redirectUrl), true, 302);
//            return;
//            echo "labas";
//        }
//        else{echo "pirmas";
//
//        }
//
//// receive authorization response
//        try {
//            //echo 'antras';
//            $token = $provider->getAccessToken('authorization_code', [
//                'code' => $_GET['code']
//            ]);
//
//        } catch (\OpenIDConnectClient\Exception\InvalidTokenException $e) {
//            $errors = $provider->getValidatorChain()->getMessages();
//
//            return;
//        }
//
//        $accessToken    = $token->getToken();
//       echo "trecias";
//        $refreshToken   = $token->getRefreshToken();
//        $expires        = $token->getExpires();
//        $hasExpired     = $token->hasExpired();
//        $idToken        = $token->getIdToken();
//        $email          = $idToken->getClaim('email', false);
//        $allClaims      = $idToken->getClaims();
//        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
//            'clientId'                => 'Klaipeda University Hospital',    // The client ID assigned to you by the provider
//            'clientSecret'            => 'cd8c16d5f0b24f4eaa979829eb24397b',   // The client password assigned to you by the provider
//            'redirectUri'             => 'http://www.kul.lt',
//            'urlAuthorize'            => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/identity',
//            'urlAccessToken'          => 'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5001/identity/connect/token',
//            'urlAccessToken'          => '',
//            'urlResourceOwnerDetails' => ''
//        ]);
//
// //If we don't have an authorization code then get one
//        if (!isset($_GET['code'])) {
//
//            // Fetch the authorization URL from the provider; this returns the
//            // urlAuthorize option and generates and applies any necessary parameters
//            // (e.g. state).
//            $authorizationUrl = $provider->getAuthorizationUrl();
//
//            // Get the state generated for you and store it to the session.
//            $_SESSION['oauth2state'] = $provider->getState();
//
//            // Redirect the user to the authorization URL.
//            header('Location: ' . $authorizationUrl);
//            echo 'niekogero';
//            exit;
//
//// Check given state against previously stored one to mitigate CSRF attack
//        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
//
//            unset($_SESSION['oauth2state']);
//            exit('Invalid state');
//
//        } else {
//
//            try {
//
//                // Try to get an access token using the authorization code grant.
//                $accessToken = $provider->getAccessToken('authorization_code', [
//                    'code' => $_GET['code']
//                ]);
//
//                // We have an access token, which we may use in authenticated
//                // requests against the service provider's API.
//                echo $accessToken->getToken() . "\n";
//                echo $accessToken->getRefreshToken() . "\n";
//                echo $accessToken->getExpires() . "\n";
//                echo ($accessToken->hasExpired() ? 'expired' : 'not expired') . "\n";
//
//                // Using the access token, we may look up details about the
//                // resource owner.
//                $resourceOwner = $provider->getResourceOwner($accessToken);
//
//                var_export($resourceOwner->toArray());
//
//                // The provider provides a way to get an authenticated API request for
//                // the service, using the access token; it returns an object conforming
//                // to Psr\Http\Message\RequestInterface.
//                $request = $provider->getAuthenticatedRequest(
//                    'GET',
//                    'http://lt-nbs-ite-domname70736.northeurope.cloudapp.azure.com:5000/api',
//                    $accessToken
//                );
//
//            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
//
//                // Failed to get the access token or user details.
//                exit($e->getMessage());
//
//            }
//
//        }
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
