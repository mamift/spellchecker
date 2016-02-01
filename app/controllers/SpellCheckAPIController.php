<?php

class SpellCheckAPIController extends BaseController {

    /**
     * Spellcheck a single word
     * @param  [string] $word [description]
     * @return [array] response array
     */
    public function correctWord($word) 
    {
        if (is_upper_case($word)) return results($word, false, SPELLCHECK_NOALLCAPS)->all();

        $response = exec_command(new SpellCheckWord($word));

        return $response->all();
    }

    /**
     * Spellchecks an entire string of words. Maximum limit of 16384 characters
     * 
     * @param  [string] $text [the text to spellcheck]
     * @return [array]       [an array containing the words that were known and unknown - for unknown words, a candidate 
     * list is also provided for each unknown word; for unknown words that had no suggested corrections, then they are 
     * sent in a separate array]
     */
    public function correctText() 
    {
        $text = Input::get('text');

        if (count($text) > MAX_TEXT_LENGTH) return results(MAX_TEXT_LENGTH, false, GENERIC_CHLIMEXCEEDED);

        $response = exec_command(new SpellCheckText($text));

        return $response->all();
    }

    /**
     * Check a string of words and return an array of words that are misspelt
     * 
     * @return [string] [description]
     */
    public function identifyMispelltWords()
    {
        $text = Input::get('text');

        if (count($text) > MAX_TEXT_LENGTH) 
            return results(MAX_TEXT_LENGTH, false, GENERIC_CHLIMEXCEEDED);
        else if (empty_or_notset($text)) 
            return r500_json(results_all('SPELLCHECK_NO_TEXT', false, SPELLCHECK_NO_TEXT));

        $response = exec_command(new IdentifyMispelltWords($text), null, 'buildUnknownWordsList');

        $response->success = $response->count > 0;
        $response->message = $response->success ? SPELLCHECK_SUCCESS : SPELLCHECK_NO_UNKNOWN_WORDs;

        return $response->all();
    }

    /**
     * This can be used to manually serialise the dictionary after a new word has been added/deleted/removed etc. Always returns true.
     * @return [array] [response array]
     */
    public function serialiseDictionary($forced)
    {
        $forced = (bool) $forced;

        $response = exec_command(new SerialiseDictionary($forced));

        return $response->all();
    }

}
