<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('index');
	}

	/**
	 * Returns a CSRF session token for POST, PUT, and PATCH requests
	 */
	public function getSessionToken()
	{
		return r200_json(results(Session::token(), true, null)->all());
	}

	/**
	 * Preflight handshake to grant access to any client that might wish to use the 
	 * SpellCheckAPI. The preflight handshake request from the client must first 
	 * satisfy two conditions: valid apikey and valid referral URL. 
	 * When they are satisfed a CSRF token is returned  to the client, and this 
	 * token must be included in every subsequent request for the session. When I 
	 * say 'subsequent request', I mean requests of all types, from GET, POST, PUT, 
	 * PATCH etc. Well only GET and POST are used anyway...
	 *
	 * Also, the route that invokes this method is also the only route that is exempt 
	 * from CSRF and API key validation, as such we invoke the CSRFVerificationFilter 
	 * class as a delegate to handle verification of authorised origin referral domains. 
	 * If no referral URL is provided, then the handshake fails. 
	 * 
	 * Moreover, because the referral URL can be spoofed, the preflight handshake must be 
	 * accompanied by a valid API key. If no API key is present the request also fails. 
	 *
	 * NOTE: PHP sessions timeout after 24 mins of no communication. If that happens a new
	 * preflight handshake must occur to gain access to the SpellChecker API.
	 * 
	 * @return [JSON] [a JSON response, indicating if the attempt was successful and if 
	 * not, why not]
	 */
	public function preflightHandshake()
	{
		$clientIP = get_ip_address();
		$clientReferralOK = exec_delegate('CSRFVerificationFilter', 'verifyOriginReferral');
		$apikeyOK = exec_delegate('APIKeyVerificationFilter', 'verifyAPIKey');

		// return r401_json(results_all(array($_SERVER, $clientReferralOK, $apikeyOK), true, AUTHORISED_REFERRAL_FQDN));

		if (!$apikeyOK)         return r401_json(results_all(array('INVALID_APIKEY' => array($clientIP)), false, INVALID_APIKEY));
		if (!$clientReferralOK) return r401_json(results_all(array('INVALID_PREFLIGHT' => array($clientIP)), false, INVALID_PREFLIGHT)); 

		$csrfToken = Session::token();
		$response = results($csrfToken, true, null);
		
		return r200_json($response->all());
	}
}