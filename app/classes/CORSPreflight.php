<?php

/**
 * 
 */
class CORSPreflight {
    
    /**
     * Verifies that the CORS preflight is valid.
     */
    public function filter()
    {
        return;
        
        // $is_CORS_ok = $this->verifyCORSPreflight();
        // if ($is_CORS_ok === true) {
            // return;
        // } else {
            // return r403_json($is_CORS_ok);
        // }
    }

    public function verifyCORSPreflight()
    {
        if (Request::method('OPTIONS')) {
            $access_control_request_method = Request::header('Access-Control-Request-Method');
            $access_control_request_headers = Request::header('Access-Control-Request-Headers');

            $isset_acrm = isset($access_control_request_method);
            $isset_acrh = isset($access_control_request_headers);

            $is_csrf_inside = strripos($access_control_request_headers, 'csrf') !== false;
            $is_apikey_inside = strripos($access_control_request_headers, 'apikey') !== false;

            if ($is_csrf_inside || $is_apikey_inside) return true;
            else {
                return results_all('CORSPREFLIGHT', false, CORSPREFLIGHT);
                // return 'bad';
            }
        }
    }

    public function isIE8XDRequest()
    {
        return;
    }
}