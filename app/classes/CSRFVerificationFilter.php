<?php

class CSRFVerificationFilter {
    
    /**
     * Verifies that a request has a CSRF token included in the header.
     */
    public function filter()
    {
        if (Session::token() != Request::header('csrf'))
            return r403_json(results_all('INVALID_CSRF_TOKEN', false, INVALID_CSRF_TOKEN));

        if ($this->verifyOriginReferral()) return;
        else return r403_json(results_all('INVALID_ORIGIN', false, INVALID_ORIGIN));
    }

    /**
     * Verifies the request is from a valid referral origin
     */
    public function verifyOriginReferral()
    {
        if (!array_key_exists('HTTP_REFERER', $_SERVER)) return false;

        $referrer = parse_url($_SERVER['HTTP_REFERER']);
        $index = 'host';
        if (!array_key_exists($index, $referrer)) $index = 'path';

        // note this method returns a boolean
        $isReferrerAuth = is_substr_in_string($referrer[$index], AUTHORISED_REFERRAL_FQDN);

        return ($isReferrerAuth || is_substr_in_string('http://localhost', $referrer[$index])); // if true, then OK to proceed!
        // return ($isReferrerAuth); // if true, then OK to proceed!
    }
}