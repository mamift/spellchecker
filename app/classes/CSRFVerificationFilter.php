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

        $comparisonVariance = 2;
        $comparison = strcmp($authDomainInReferrer, AUTHORISED_REFERRAL_FQDN);
        $exactMatchOfAuthReferralDomain = $comparison == 0;
        $partialMatchOfAuthReferralDomain =  (($comparison > 0) && ($comparison < $comparisonVariance)) || (($comparison < 0) && ($comparison > (0 - $comparisonVariance)));

        return ($exactMatchOfAuthReferralDomain || $partialMatchOfAuthReferralDomain) // if true, then OK to proceed!
    }