<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    $allNamespaces = get_namespaces();
    $allClasses = get_namespaced_classes();

    Debugbar::info($allClasses);
    Debugbar::info($allNamespaces);

    $bean = R::dispense('test');
    $bean->title =  "this is a test";

	return View::make('hello')->with(array('test_bean' => $bean));
});

Route::get('/test', function() {
    return app_path();
});
Route::get('/cwd', function() {
    return getcwd();
});

Route::get('/phpinfo', function() {
    phpinfo();
});

Route::get('/nukedb', function() {
    R::nuke();

    return 'Database nuked';
});

Route::group(array('prefix' => 'v1'), function() {
    require('SpellCheckAPI_routes.php');
    // require('WordsAPI_routes.php');

    /**
     * Returns a new token for CSRF (cross-site request forgery) validation for PUT,PATCH,POST requests
     */
    Route::get('/session', "HomeController@session");

    /**
     * Generic error message
     */
    Route::any('{any}', function() {
        return r404_json(array(
            'success' => 'false',
            'message' => GENERIC_404
        ));
    })->where('any', '(.*)');
});

/**
 * Generic catch all route for unknown routes; MUST always be LAST
 */
Route::any('{any}', function() {
    return r404_json(array(
        'success' => 'false',
        'message' => GENERIC_404
    ));
})->where('any', '(.*)');
