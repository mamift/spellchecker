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
    return r200_json(array(
            'success' => 'If you can see this, then it is working',
            'data'    => get_server_url_prefix() . $_SERVER['HTTP_HOST'] . '/documentation',
            'message' => GENERIC_HELP,
        )
    );
});

/**
 * IE8 compatible endpoints
 */
Route::group(array('prefix' => 'api/vIE8'), function() {

    /**
     * Preflight handshake for first-time setup (as in, upon the initiaion of a new session)
     */
    Route::post('/preflight_handshake', 'HomeController@preflightHandshakeIE8');

    /**
     * For the spellchecker API
     */
    require('SpellcheckAPI_IE8_routes.php');

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
 * The regular API endpoints for non-IE8,9 browsers
 */
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

require('southern_cross_paper_survey_requests.php');

/**
 * Testing and development routes; remove in production push
 */
// require('Test_routes.php');


/**
 * Generic catch all route for unknown routes; this rule MUST always be LAST for it to work.
 */
Route::any('{any}', function() {
    return r404_json(array(
        'success' => 'false',
        'message' => 'GENERIC_404'
    ));
})->where('any', '(.*)');
