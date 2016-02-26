<?php

/**
 * 
 */
class CORSPreflight {
    
    /**
     * Firefox is the one mainstream browser that seems to always want to preflight POST requests when it is CORS
     * 
     * @return [void or JSON]
     */
    public function filter()
    {
        if (Request::method() !== 'OPTIONS') { // cors preflight requests are always with the OPTIONS verb
            return r401_json(results_all('CORSPREFLIGHT2', false, CORSPREFLIGHT2));
        }

        if ($this->verifyCORSPreflight()) return r200_json(results_all(array('CORSPREFLIGHT_OK' => Request::method()), true, CORSPREFLIGHT_OK));
        else return r401_json(results_all('CORSPREFLIGHT', false, CORSPREFLIGHT));
    }

    /**
     * Verifies that the CORS preflight request is valid.
     * 
     * @return [void or JSON] 
     */
    public function verifyCORSPreflight()
    {
        $access_control_request_method = Request::header('Access-Control-Request-Method');
        $access_control_request_headers = Request::header('Access-Control-Request-Headers');

        $isset_acrm = isset($access_control_request_method);
        $isset_acrh = isset($access_control_request_headers);

        $is_csrf_inside = isset($accrh) ? strripos($access_control_request_headers, 'csrf') !== false : false;
        $is_apikey_inside = isset($acrm) ? strripos($access_control_request_headers, 'apikey') !== false : false;

        if ($is_csrf_inside && $is_apikey_inside) return;

        return results_all('CORSPREFLIGHT', false, CORSPREFLIGHT);
    }
}