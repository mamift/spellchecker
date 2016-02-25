<?php

class APIKeyVerificationFilter extends CORSPreflight {
    
    /**
     * Filter requests with invalid API keys
     * 
     * @return [void or JSON] [void is returned if the request may pass through the filter]
     */
    public function filter() {
        if (Request::method('OPTIONS')) return;

        if ($this->verifyAPIKey()) return;
        else {
            return r401_json(results('INVALID_APIKEY', false, INVALID_APIKEY)->all());
        }
    }

    /**
     * Verifies if an API key in the request header is valid; 
     * it's basically a wrapper for a R:: extension function.
     *
     * This is in it's own method so it can be delegated if need be.
     * 
     * @return [bool] [true if the API key is valid, false otherwise]
     */
    public function verifyAPIKey() 
    {
        $apikey = Request::header('apikey');

        return R::isAPIKeyValid($apikey);
    }

    /**
     * Verifies if an API key in the request body is valid; 
     * it's basically a wrapper for a R:: extension function.
     *
     * This is in it's own method so it can be delegated if need be.
     * 
     * @return [bool] [true if the API key is valid, false otherwise]
     */
    public function verifyAPIKeyIE8() 
    {
        $apikey = Input::get('apikey');

        return R::isAPIKeyValid($apikey);
    }
}