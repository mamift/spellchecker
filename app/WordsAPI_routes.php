<?php

Route::group(['prefix' => 'words'], function() {
    /**
     * server_url/words
     */
    Route::get('/', function() {
        return r200_json([
            'message' => GENERIC_HELP
        ]);
    });

    /**
     * Get all words
     * server_url/words/all
     */
    Route::get('/all', "WordsAPIController@index");

    /**
     * Paginated version of /all route above
     * server_url/words/all/1
     */
    Route::get('/all/{page}', "WordsAPIController@index");

    /**
     * Paginated version of the above route, with limits
     * server_url/words/all/1/1000
     */
    Route::get('/all/{page}/{limit}', "WordsAPIController@index");

    /**
     * Get all words beginning with a string
     * server_url/words/begins/{string}
     */
    Route::get('/begins/{string}', "WordsAPIController@getAllWordsBeginningWithString");

    /**
     * A paginated version of the above route with limits
     * server_url/words/begins/{string}/{page}/{limit}
     */
    Route::get('/begins/{string}/{page}/{limit}', "WordsAPIController@getAllWordsBeginningWithString");

    /**
     * Returns a single word; can pass an ID or string to search
     * server_url/words/{word}
     */
    Route::get('/{word}', "WordsAPIController@show");

    /**
     * Add a new word
     * server_url/words/create
     */
    Route::post('/create', "WordsAPIController@store");

    /**
     * Updates a word
     */
    Route::put('/update', "WordsAPIController@update"); // friendly error message
    Route::put('/update/{id}', "WordsAPIController@update");

    /**
     * Also updates a word
     */
    Route::patch('/update', "WordsAPIController@update"); // friendly error message
    Route::patch('/update/{id}', "WordsAPIController@update");
});