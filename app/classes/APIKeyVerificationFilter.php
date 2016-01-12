<?php

class APIKeyVerificationFilter {
    
    public function filter()
    {
        $apikey = Request::header('apikey');

        if (R::isAPIKeyValid($apikey)) return;
        else {
            return r401_json(results(null, false, INVALID_APIKEY)->all());
        }
    }
}