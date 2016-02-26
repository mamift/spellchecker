<?php

/**
 * This is a customised version of the CSRFVerificationFilter used by Laravel.
 * The CSRF token is now included in the header and not as a hidden input value.
 */
class CSRFVerificationFilter extends CORSPreflight {

    public function __construct()
    {
        $this->request = Request::instance();
    }
    
    /**
     * 'aicmkgpgakddgnaphhhpliifpcfhicfo' is for the Postman Chrome extension
     * @var array
     */
    public $ok_referral_or_origin_domains = array(AUTHORISED_REFERRAL_FQDN, AUTHORISED_REFERRAL_SLDN, 'localhost', 'aicmkgpgakddgnaphhhpliifpcfhicfo');
    public $ok_referral_origin_schemes = array('chrome-extension', 'https');

    /**
     * Verifies that a request has a CSRF token included in the header.
     */
    public function filter()
    {
        $invalid_csrf_token_response = array('should_be' => Session::token(), 'provided' => Request::header('csrf'));
        if (Session::token() != Request::header('csrf'))
            return r403_json(results_all($invalid_csrf_token_response, false, INVALID_CSRF_TOKEN));

        if ($this->verifyOriginReferral()) return;
        else return r403_json(results_all('INVALID_ORIGIN', false, INVALID_ORIGIN));
    }

    /**
     * IE8 compatible version of the filter() method
     */
    public function filterIE8()
    {
        if ($this->verifyOriginReferralIE8()) return;

        return r403_json(results_all('INVALID_ORIGIN', false, INVALID_ORIGIN));
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
        $isReferrerAuth = in_array($referrer[$index], $this->ok_referral_or_origin_domains);

        return ($isReferrerAuth || is_substr_in_string('localhost', $referrer[$index])); // if true, then OK to proceed!
        // return ($isReferrerAuth); // if true, then OK to proceed!
    }

    /**
     * Verifies the request is from a valid referral origin (IE8 compatible)
     */
    public function verifyOriginReferralIE8()
    {
        if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) return false;

        $referrer = parse_url($_SERVER['HTTP_ORIGIN']);
        $scheme = $referrer['scheme'];
        $host = $referrer['host'];

        // if the request is coming from a chrome-extension, its probably postman
        if ($a = (in_array($scheme, $this->ok_referral_origin_schemes) && in_array($scheme, $this->ok_referral_or_origin_domains))) {
            return $a;
        }

        $index = 'host';
        if (!array_key_exists($index, $referrer)) throw new Exception('No [host] index in parse_url $_SERVER["HTTP_ORIGIN"]!');

        return in_array($referrer[$index], $this->ok_referral_or_origin_domains);
    }
}