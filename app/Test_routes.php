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