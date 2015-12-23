<?php


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
