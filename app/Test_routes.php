<?php


Route::get('/index', function()
{
    $allNamespaces = get_namespaces();
    $allClasses = get_namespaced_classes();

    Debugbar::info($allClasses);
    Debugbar::info($allNamespaces);

    $bean = R::dispense('test');
    $bean->title =  "this is a test";

    return View::make('index')->with(array('test_bean' => $bean));
});

Route::get('/test', function() {
    return app_path();
});

Route::get('/clear_debugbar_storage', function() {
    
});

Route::get('/cwd', function() {
    return getcwd();
});

Route::get('/phpinfo', function() {
    Debugbar::disable();
    phpinfo();
});

Route::get('/nukedb', function() {
    R::nuke();

    return 'Database nuked';
});

Route::get('/class_exists/{name}', function($name) {
    return array('class_name' => $name, 'exists?' => class_exists($name));
});

Route::get('/get_classes', function() {
    return get_declared_classes();
});


Route::get('/test/1', function() {
    if (!isset($_SERVER['HTTP_REFERER'])) return 'false referrer not set';

    $referrer = $_SERVER['HTTP_REFERER'];
    $authDomainInReferrer = strstr($referrer, AUTHORISED_REFERRAL_FQDN);

    if (is_string($authDomainInReferrer)) {
        $comparisonVariance = 2;
        $comparison = strcmp($authDomainInReferrer, AUTHORISED_REFERRAL_FQDN);
        $exactMatchOfAuthReferralDomain = $comparison == 0;
        $partialMatchOfAuthReferralDomain =  (($comparison > 0) && ($comparison < $comparisonVariance)) || (($comparison < 0) && ($comparison > (0 - $comparisonVariance)));

        if ($exactMatchOfAuthReferralDomain || $partialMatchOfAuthReferralDomain) return 'true'; // OK to proceed!
        else {
            return 'false - not exact or partial match';
        }
    } else {
        return 'not a string';
    }
});

Route::get('/test/2', function() {
    return r200_json(array('is_substr_in_string' => is_substr_in_string('http://localhost', 'localhost')));
    // return r200_json(array('is_string_in_haystack' => strstr('http://localhost', 'localhost')));
});

Route::get('/test/3', function() {
    $pos = strpos('http://localhost:15230/', 'localhost');
    $len = strlen('localhost');
    $substr = substr('http://localhost:15230/', $pos, $len);

    return r200_json(array(
        'strpos' => strpos('http://localhost:15230/', 'localhost'),
        'length' => strlen('localhost'),
        'substr' => substr('http://localhost:15230/', $pos, $len),
        'substr_in_string' => strcmp($substr, 'localhost'),
        'is_substr_in_string' => is_substr_in_string('http://localhost', 'localhost')
    ));
    // return r200_json(array('is_string_in_haystack' => strstr('http://localhost', 'localhost')));
});

Route::get('/test/4', function(){
    
    $replace = parse_url($_SERVER['HTTP_REFERER']);

    return r200_json($replace['host']);
});