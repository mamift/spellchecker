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
    function results_response($data = array(), $success = false, $message = '(no message has been set)') {
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
    function results($data = array(), $success = false, $message = '(no message has been set)') {
        return (new Results($data, $success, $message));
    }
}

if (!function_exists('exec_command')) {
    /**
     * Executes a command
     * Can be invoked in either of two ways: exec_command('SpellCheckWord', $word);
     * The name of the class as a string plus constructor arguments,
     * Or: exec_command(new SpellCheckWord($word));
     * A new instance of the command class you wish to execute
     * 
     * @return [Results object] [the results of the command]
     */
    function exec_command($command_class, $constructor_arguments = NULL) {

        $command_results = NULL;

        $sm_sub_attempt_exec = function($com) use (&$command_results) {
            if (method_exists($com, 'handle')) {
                $command_results = $com->handle();

                // if the command returns a Results object, then just return the object
                if ($command_results instanceof Results && method_exists($command_results, 'all')) {
                    return $command_results;
                } else { // otherwise, return the command_results inside a new Results object
                    $command_results = results($command_results, true);

                    if (property_exists($com, 'message')) {
                        $command_results->message = $com->message;
                    }

                    return $command_results;
                }
            } else {
                $command_results = results('DELEGATION_ERROR_METHODER', false, DELEGATION_ERROR_METHODER);
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
