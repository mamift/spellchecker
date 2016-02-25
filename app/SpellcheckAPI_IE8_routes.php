<?php



Route::group(array('prefix' => 'spellcheck'), function() {
    /**
     * Identifies only misspelt words in the text provided
     */
    Route::post('/identify_misspelt_words', 'SpellCheckAPIControllerIE8@identifyMispelltWords');

    /**
     * server_url/spellcheck
     */
    Route::get('/', function() {
        return r200_json(array(
            'message' => GENERIC_HELP,
            'data' => get_server_url_prefix() . $_SERVER['HTTP_HOST'] . '/documentation'
        ));
    });

    /**
     * Spellcheck (suggest proper word candidates) a word
     * server_url/spellcheck/{word}
     */
    Route::get('/{apikey}_{csrf}_{word}', "SpellCheckAPIControllerIE8@correctWord");

    /**
     * Spellcheck some text, up to a maximum of 16384 words (or 65535 characters whichever limit is hit first).
     * server_url/spellcheck/
     */
    Route::post('/', "SpellCheckAPIControllerIE8@correctText");

    /**
     * Serialise the dictionary. 
     * To forcibly serialise the dictionary, pass a truthy value after the /serialise_dictionary/, like a number or string
     * e.g. /serialise_dictionary/1 (as 1 is a truthy value)
     */
    Route::get('/serialise_dictionary/{force}', "SpellCheckAPIControllerIE8@serialiseDictionary");
});