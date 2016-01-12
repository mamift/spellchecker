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
     * @return [string]       [the corrected text]
     */
    public function correctText(Request $request) 
    {
        $text = $request->get('text');

        if (count($text) > 16384) return results(16384, false, GENERIC_CHLIMEXCEEDED);

        $response = exec_command();

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
