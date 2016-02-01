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

Route::get('/', function() {
    return r200_json(results_all(null, true, 'If you can see this, then it is working'));
});

/**
 * Testing and development routes; remove in production push
 */
require('Test_routes.php');

Route::group(array('prefix' => 'api/v1'), function() {

    /**
     * Preflight handshake for first-time setup (as in, upon the initiaion of a new session)
     */
    Route::get('/preflight_handshake', 'HomeController@preflightHandshake');

    /**
     * For the spellchecker API
     */
    require('SpellcheckAPI_routes.php');

    /**
     * For the Words API (edit words in the dictionary)
     * Incomplete
     */
    // require('WordsAPI_routes.php');

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
 * Generic catch all route for unknown routes; this rule MUST always be LAST for it to work.
 */
Route::any('{any}', function() {
    return r404_json(array(
        'success' => 'false',
        'message' => GENERIC_404
    ));
})->where('any', '(.*)');
