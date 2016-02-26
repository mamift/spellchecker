<?php



Route::group(array('prefix' => 'spellcheck'), function() {
    /**
     * Identifies only misspelt words in the text provided
     */
    Route::post('/identify_misspelt_words', 'SpellCheckAPIControllerIE8@identifyMispelltWords');

    /**
     * Spellcheck (suggest proper word candidates) a word
     * server_url/spellcheck/{word}
     */
    Route::post('/{word}', "SpellCheckAPIControllerIE8@correctWord");

    /**
     * Spellcheck some text, up to a maximum of 16384 words (or 65535 characters whichever limit is hit first).
     * server_url/spellcheck/
     */
    Route::post('/', "SpellCheckAPIControllerIE8@correctText");
});