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

	return View::make('hello');
});

Route::get('/test', function() {
    return app_path();
});

Route::get('/phpinfo', function() {
    phpinfo();
});

Route::get('/nukedb', function() {
    R::nuke();

    return 'Database nuked';
});