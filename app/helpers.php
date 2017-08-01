<?php

if (!function_exists('r200_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 200 (OK!) HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r200_json($data) {
        return Response::json($data, 200, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('r201_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 201 (new resource created) HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r201_json($data) {
        return Response::json($data, 201, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('r404_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 404 Not found HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r404_json($data) {
        return Response::json($data, 404, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('r403_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 403 Forbidden HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r403_json($data) {
        return Response::json($data, 403, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('r401_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 401 Unauthorised HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r401_json($data) {
        return Response::json($data, 401, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('r500_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 500 Server Error status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r500_json($data) {
        return Response::json($data, 500, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('rb_r200_json')) {
    /**
     * Export Redbean data as JSON output, returning 200 HTTP status code.
     * @param  [Redbean] $redbeanData [the Redbean class to extract data from]
     * @return [JSON]              [JSON array]
     */
    function rb_r200_json($redbeanData) {
        $response = R::exportAll($redbeanData);
        return Response::json($response, 200, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('rb_r404_json')) {
    /**
     * Export Redbean data as JSON output, returning 404 HTTP status code.
     * @param  [Redbean] $redbeanData [the Redbean class to extract data from]
     * @return [JSON]              [JSON array]
     */
    function rb_r404_json($redbeanData) {
        $response = R::exportAll($redbeanData);
        return Response::json($response, 404, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('strisallcaps')) {
    /**
     * Determine if a string is in all caps
     * @param  [string] $string [the string to determine]
     * @return [boolean]         [true if it is ALL caps, false otherwise]
     */
    function strisallcaps($string) {
        return (strcmp($string, strtoupper($string)) === 0);
    }
}

if (!function_exists('r501_json')) {
    /**
     * Accepts a PHP array and returns JSON data with the 501 (Not implemented) HTTP status code.
     * @param  [array] $data [the PHP data to return]
     * @return [JSON]       [JSON array]
     */
    function r501_json($data) {
        return Response::json($data, 501, array(), JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('coerce_to_int')) {
    /**
     * Coerce the value into an integer
     * @param  [any] $intValue [any value to coerece]
     * @return [int]           [the value as an integer]
     */
    function coerce_to_int($intValue) {
        if (!is_int($intValue)) {
            if ((int) $intValue > 0) {
                $intValue = (int) $intValue;
            }
        }

        return $intValue;
    }
}

if (!function_exists('get_namespaces')) {
    /**
     * Gets all namespaces loaded in the current app, returns it as an array
     * @return [array] [array of namespaces]
     */
    function get_namespaces() {
        $namespaces = array();
        foreach(get_declared_classes() as $name) {
            if (preg_match_all("@[^\\\]+(?=\\\)@iU", $name, $matches)) {
                $matches = $matches[0];
                $parent = &$namespaces;
                while (count($matches)) {
                    $match = array_shift($matches);
                    if (!isset($parent[$match]) && count($matches))
                        $parent[$match] = array();
                    $parent = &$parent[$match];
                }
            }
        }
        return $namespaces;
    }
}

if (!function_exists('get_namespaced_classes')) {
    /**
     * Get all classes as an array
     * @return [array] [array of class names]
     */
    function get_namespaced_classes() {
        $classes = get_declared_classes();
        sort($classes, SORT_STRING);
        foreach ($classes as $class) {
        }
        return $classes;
    }
}

if (!function_exists('get_ip_address')) {

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range. Used by get_ip_address() 
     */
    function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

}

if (!function_exists('get_ip_address')) {

    /**
     * A slightly more reliable way to get a client's IP address
     * 
     * @return [string] [the client's IP address]
     */
    function get_ip_address() {
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if (validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }
}

if (!function_exists('is_upper_case')) {
    /**
     * If a word is uppercase or not...
     * @return boolean [is upper case?]
     */
    function is_upper_case($word) {
        return (strcmp(strtoupper($word), $word) == 0);
    }
}

if (!function_exists('results_response')) {
    /**
     * Short hand for instantiating a new Results object
     * @param  array   $data    [the data]
     * @param  boolean $success [does this Result represent a successful one?]
     * @param  string  $message [the message]
     * @return [Results]           [Results object]
     */
    function results_response($data = array(), $success = false, $message = NULL) {
        $results = (new Results($data, $success, $message));
        return $results->all();
    }
}

if (!function_exists('results')) {
    /**
     * Short hand for instantiating a new Results object
     * @param  array   $data    [the data]
     * @param  boolean $success [does this Result represent a successful one?]
     * @param  string  $message [the message]
     * @return [Results]           [Results object]
     */
    function results($data = array(), $success = false, $message = NULL) {
        return (new Results($data, $success, $message));
    }
}

if (!function_exists('results_all')) {
    /**
     * Short hand for instantiating a new Results object and invoking the all() method 
     * which gets all data properties set
     * @param  array   $data    [the data]
     * @param  boolean $success [does this Result represent a successful one?]
     * @param  string  $message [the message]
     * @return [Array]           [array of all public properties set on the Results object]
     */
    function results_all($data = array(), $success = false, $message = NULL) {
        $results = new Results($data, $success, $message);
        return ($results->all());
    }
}

if (!function_exists('empty_or_notset')) {
    
    /**
     * Shorthand for both empty() and !isset() tests
     * @param  [any] $thingie [the thing to check]
     * @return [boolean]          [if it satisfies either test]
     */
    function empty_or_notset($thingie) {
        return (empty($thingie) || !isset($thingie));
    }
}

if (!function_exists('not_empty_or_isset')) {
    
    /**
     * Shorthand for both !empty() and isset() tests
     * @param  [any] $thingie [the thing to check]
     * @return [boolean]          [if it satisfies either test]
     */
    function not_empty_or_isset($thingie) {
        return (!empty($thingie) || isset($thingie));
    }
}

if (!function_exists('exec_command')) {
    /**
     * Executes a command
     * Can be invoked in either of two ways: exec_command('SpellCheckWord', $word, $custom_method_name);
     * The name of the class as a string plus constructor arguments,
     * Or: exec_command(new SpellCheckWord($word));
     * A new instance of the command class you wish to execute
     *
     * @param [Object] $command_class [the command to execute]
     * @param [mixed] $constructor_arguments [any arguments to pass to the constructor if invoking a command by its class name]
     * @param  [mixed] $custom_method_name [invoke another public method, instead of handle()]
     * @return [Results object] [the results of the command]
     */
    function exec_command($command_class, $constructor_arguments = NULL, $custom_method_name = "") {

        $command_results = NULL;

        $sm_sub_attempt_exec = function($com) use (&$command_results, $custom_method_name) {

            if (!method_exists($com, 'handle') && empty_or_notset($custom_method_name)) {
                $command_results = results('DELEGATION_ERROR_METHODER', false, DELEGATION_ERROR_METHODER);
                return;
            }

            // invoke custom method instead of handle. must be public!
            if (not_empty_or_isset($custom_method_name) && method_exists($com, $custom_method_name)) {
                $m = $com->{$custom_method_name}();
                $command_results = $m;
            } else 
                $command_results = $com->handle();

            // if the command returns a Results object, then just exit the closure
            if ($command_results instanceof Results && method_exists($command_results, 'all')) {
                return;
            } else { // otherwise, return the command_results inside a new Results object
                $command_results = results($command_results, true);

                // if the command object has a public message property, lets pass that onto the results object
                if (property_exists($com, 'message')) {
                    $command_results->message = $com->message;
                }
            }
        };

        if (is_object($command_class)) {

            $sm_sub_attempt_exec($command_class);

        } else if (is_string($command_class)) {

            if (class_exists($command_class)) {
                $command = new $command_class($constructor_arguments);

                $sm_sub_attempt_exec($command);

            } else {
                return results('DELEGATION_ERROR_NOCLASS', false, DELEGATION_ERROR_NOCLASS);
            }
        }

        return $command_results;
    }
}

/**
 * Shorthand for getting the all() array on a Results object when invoking exec_command()
 * @return  [array] [command results]
 */
if (!function_exists('exec_command_all')) {
    function exec_command_all($command_class, $constructor_arguments = NULL, $custom_method_name = "") {
        $response = exec_command($command_class, $constructor_arguments, $custom_method_name);
        return $response->all();
    }
}

if (!function_exists('exec_delegate')) {

    /**
     * Similar in concept to exec_command, but only accepts class names and method names (as strings).
     * Can be used for late runtime execution of helper classes (they don't have to be commands).
     * All delegated methods must be public, obviously.
     * 
     * @param  [class object] $delegate_class [object]
     */
    function exec_delegate($delegate_class, $delegate_method, $constructor_arguments = null) {

        if (class_exists($delegate_class)) {

            if (method_exists($delegate_class, $delegate_method)) {
                $delegatee = new $delegate_class($constructor_arguments);
                $return = $delegatee->$delegate_method();

                return $return;
            } else {
                return results('DELEGATION_ERROR_NOMETHOD', false, DELEGATION_ERROR_NOMETHOD);
            }
        } else {
            return results('DELEGATION_ERROR_NOCLASS', false, DELEGATION_ERROR_NOCLASS);
        }
    }
}

if (!function_exists('is_substr_in_string')) {

    /**
     * Gets a partial match of two strings
     * 
     * @param  [string] $haystack [haystack, string 1]
     * @param  [string] $needle [needle, string 2]
     * @param  [int] $covariance [the variance of letters that each string can vary by in the comparison]
     * @return [bool]       [true if exact or partial, false if not]
     */
    function is_substr_in_string($haystack, $needle, $covariance = 2, &$debug = NULL) {
        $pos = strpos($haystack, $needle);
        $length = strlen($needle);

        if ($pos === false) return false;

        $substr = substr($haystack, $pos, $length);

        if (empty($substr)) return false;

        $comparison = strcmp($substr, $needle);
        $exactMatchOfStrings = $comparison == 0;

        return ($comparison == 0);
    }
}

if (!function_exists('exception')) {

    /**
     * Shorthand function for throwing a new exception 
     */
    function exception($type, $message = '(no message has been set)' ) {
        throw new Exception($type . ' - ' . $message);
    }
}

if (!function_exists('get_server_url_prefix')) {

    /**
     * Shorthand function for automatically determining the server url prefix http:// or https://
     */
    function get_server_url_prefix() {
        $protocol = 'http://'; 
        $https_set = isset($_SERVER['HTTPS']);
        if ($https_set) 
            $https_svr_index = $https_set ? $_SERVER['HTTPS'] : false;

        $https_is_on = ($https_set && ($https_svr_index == 'on' || $https_svr_index == 1));
        // for use when the site is behind a reverse proxy
        $https_proxy_fon = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
        
        if ($https_set && ($https_is_on || $https_proxy_fon)) 
            $protocol = 'https://';

        return $protocol;
    }
}

if (!function_exists('array_key_exists_case_insensitive')) {

    function array_key_exists_case_insensitive($key, $array) {
        $array_copy = array_change_key_case($array, CASE_LOWER);
        // for ($i = 0; $i < count($array); $i++) { 
        //     $f = strripos($array[$i], $key);
        //     if ($f !== false && $f > -1) return true;
        // }
        return array_key_exists($key, $array_copy);
    }
}