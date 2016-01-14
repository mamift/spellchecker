<?php

class CSRFVerificationFilter {
    
    /**
     * Verifies that a request has a CSRF token included in the header.
     */
    public function filter()
    {
        if (Session::token() != Request::header('csrf')) {
            // throw new Illuminate\Session\TokenMismatchException;
            return r403_json(results('INVALID_CSRF_TOKEN', false, INVALID_CSRF_TOKEN)->all());
        } else {

            if ($this->verifyOriginReferral()) {
                return;
            } else {
                r403_json(results('INVALID_PREFLIGHT', false, INVALID_PREFLIGHT)->all());
            }
        }

        return;
    }

    /**
     * Verifies the request is from a valid referral origin
     */
    public function verifyOriginReferral()
    {
        if (empty($_SERVER['HTTP_REFERRER']) || !isset($_SERVER['HTTP_REFERRER'])) return false;

        $referrer = $_SERVER['HTTP_REFERRER'];
        $authDomainInReferrer = strstr($referrer, AUTHORISED_REFERRAL_FQDN);

        if (!is_string($authDomainInReferrer)) return false;

        // note this method returns a boolean
        $exactOrPartialMatch = get_partial_string_match($authDomainInReferrer, AUTHORISED_REFERRAL_FQDN);

        return $exactOrPartialMatch; // if true, then OK to proceed!
    }
}