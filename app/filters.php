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
    if (!Request::secure()) return r403_json(results_all('NOT_HTTPS', false, NOT_HTTPS));

    $exemptRoutes = Request::is('api/v1/preflight_handshake');

    // if not an exempt route, apply filters
    if ($exemptRoutes === false) {
        Route::when('api/v1/*', 'corspreflight');
        Route::when('api/v1/*', 'csrf');
        Route::when('api/v1/*', 'apikeyverification');
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

Route::filter('csrf', 'CSRFVerificationFilter');
