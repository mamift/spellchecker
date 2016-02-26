<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    if (!Request::secure() && strripos(!Request::root(), 'localhost') !== false) return r403_json(results_all(array('NOT_HTTPS' => Request::root()), false, NOT_HTTPS));

    $exemptRoutes = Request::is('api/v1/preflight_handshake') || Request::is('api/vIE8/preflight_handshake');

    if ($exemptRoutes === false) {
        // cors preflight chanel; firefox does it all the time appparently
        if (Request::method() === 'OPTIONS') { 
            Route::when('api/v1/*', 'corspreflight');
        }
        // if not an exempt route, apply filters
        // Route::when('api/v1/*', 'csrf');
        Route::when('api/v1/*', 'apikeyverification');

        // Route::when('api/vIE8/*', 'csrf_ie8');
        Route::when('api/vIE8/*', 'apikeyverification_ie8');
    }
});


App::after(function($request, $response)
{
    $response->header('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
    $response->header('Cache-Control', 'max-age=3600, public');
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('corspreflight', 'CORSPreflight');

Route::filter('apikeyverification', 'APIKeyVerificationFilter');
Route::filter('apikeyverification_ie8', 'APIKeyVerificationFilter@filterIE8');

Route::filter('csrf', 'CSRFVerificationFilter');
Route::filter('csrf_ie8', 'CSRFVerificationFilter@filterIE8');
