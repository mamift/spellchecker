<?php

Route::group(array('prefix' => 'spellcheck'), function() {
    /**
     * server_url/words
     */
    Route::get('/', function() {
        return r200_json(array(
            'message' => GENERIC_HELP
        ));
    });

    /**
     * Spellcheck (suggest proper word candidates) a word
     * server_url/spellcheck/{word}
     */
    Route::get('/{word}', "SpellCheckAPIController@correctWord");

    /**
     * Spellcheck some text, up to a maximum of 16384 words (65535 characters whichever limit is hit first).
     * server_url/spellecheck/
     */
    Route::post('/', "SpellCheckAPIController@correctText");

    /**
     * Serialise the dictionary. 
     * To forcibly serialise the dictionary, pass a truthy value after the /serialise_dictionary/, like a number or string
     * e.g. /serialise_dictionary/1 (as 1 is a truthy value)
     */
    Route::get('/serialise_dictionary/{force}', "SpellCheckAPIController@serialiseDictionary");
});