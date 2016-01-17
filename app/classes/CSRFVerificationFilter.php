<?php

class CSRFVerificationFilter {
    
    /**
     * Verifies that a request has a CSRF token included in the header.
     */
    public function filter()
    {
        if (Session::token() != Request::header('csrf'))
            return r403_json(results('INVALID_CSRF_TOKEN', false, INVALID_CSRF_TOKEN)->all());

        if ($this->verifyOriginReferral()) return;
        else return r403_json(results('INVALID_ORIGIN', false, INVALID_ORIGIN)->all());
    }

    /**
     * Verifies the request is from a valid referral origin
     */
    public function verifyOriginReferral()
    {
        if (empty($_SERVER['HTTP_REFERER']) || !isset($_SERVER['HTTP_REFERER'])) return false;

        $referrer = $_SERVER['HTTP_REFERER'];

        // note this method returns a boolean
        $isReferrerAuth = is_substr_in_string($referrer, AUTHORISED_REFERRAL_FQDN);

        return ($isReferrerAuth || is_substr_in_string('http://localhost', $referrer)); // if true, then OK to proceed!
        // return ($isReferrerAuth); // if true, then OK to proceed!
    }
}