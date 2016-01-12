<?php

class CSRFVerificationFilter {
    
    public function filter()
    {
        if (Session::token() != Request::header('csrf')) {
            // throw new Illuminate\Session\TokenMismatchException;
            return r403_json(results(null, false, INVALID_CSRF_TOKEN)->all());
        }

        return;
    }
}