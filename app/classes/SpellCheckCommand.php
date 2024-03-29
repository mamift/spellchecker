<?php

/* 
This class implements code by Felipe Ribeiro. It has been modified and adapted for use in Laravel, 
and the original can be found in http:// www.phpclasses.org/package/4859-PHP-Suggest-corrected-spelling-text-in-pure-PHP.html
*/

/*
*************************************************************************** 
*   Copyright (C) 2008 by Felipe Ribeiro                                  * 
*   felipernb@gmail.com                                                   * 
*   http:// www.feliperibeiro.com                                         * 
*                                                                         * 
*   Permission is hereby granted, free of charge, to any person obtaining * 
*   a copy of this software and associated documentation files (the       * 
*   "Software"), to deal in the Software without restriction, including   * 
*   without limitation the rights to use, copy, modify, merge, publish,   * 
*   distribute, sublicense, and/or sell copies of the Software, and to    * 
*   permit persons to whom the Software is furnished to do so, subject to * 
*   the following conditions:                                             * 
*                                                                         * 
*   The above copyright notice and this permission notice shall be        * 
*   included in all copies or substantial portions of the Software.       * 
*                                                                         * 
*   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,       * 
*   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF    * 
*   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.* 
*   IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR     * 
*   OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, * 
*   ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR * 
*   OTHER DEALINGS IN THE SOFTWARE.                                       * 
*************************************************************************** 
*/ 

/**
 * This is a base class used by specialised commands (SpellCheckWord, SerialiseDictionary for instance)
 */
abstract class SpellCheckCommand extends Command
{
    protected $NWORDS;
    protected $file;
    protected $wordFile;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->file = app_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'serialised_dictionary.txt';
        $this->wordFile = app_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'words.txt';

        if (!file_exists($this->file)) {
            $this->serialiseDictionary();
        } else {
            $this->NWORDS = unserialize(file_get_contents($this->file));
        }
    }

    /**
     * Reads a text and extracts the list of words
     *
     * @param string $text
     * @return array The list of words
     */
    protected function words($text) 
    {
        $matches = array();
        // preg_match_all("/[a-z]+/", strtolower($text), $matches);
        preg_match_all("/[a-z']+/i", $text, $matches);
        return $matches[0];
    }

    /**
     * Creates a table (dictionary) where the word is the key and the value is its relevance 
     * in the text (measured by the number of times it appears)
     *
     * @param array $words
     * @return array
     */
    protected function train(array $words) 
    {
        $model = array();
        $count = count($words);
        for ($i = 0; $i < $count; $i++) {
            $word = $words[$i];
            if (!isset($model[$word]) || empty($model[$word])) {
                $model[$word] = 1;
            }
            $model[$word] += 1;
        }
        return $model;
    }

    /**
     * Generates a list of possible "disturbances" on the passed string
     *
     * @param string $word
     * @return array
     */
    protected function edits1($word) 
    {
        $alphabet = "abcdefghijklmnopqrstuvwxyz\'";
        $alphabet = str_split($alphabet);
        $n = strlen($word);
        $edits = array();
        for ($i = 0; $i < $n; $i++) {
            $edits[] = substr($word, 0, $i) . substr($word, $i + 1); // deleting one char
            foreach ($alphabet as $c) {
                $edits[] = substr($word, 0, $i) . $c . substr($word, $i + 1); // substituting one char
            }
        }
        for ($i = 0; $i < $n - 1; $i++) {
            $edits[] = substr($word, 0, $i) . $word[$i + 1] . $word[$i] . substr($word, $i + 2); // swapping chars order
        }
        for ($i=0; $i < $n + 1; $i++) {
            foreach ($alphabet as $c) {
                $edits[] = substr($word, 0, $i) . $c . substr($word, $i); // inserting one char
            }
        }

        return $edits;
    }

    /**
     * Generate possible "disturbances" in a second level that exist on the dictionary. This may return duplicates, so
     * array_unique() is called on the return array.
     *
     * @param string $word
     * @return array
     */
    protected function knownEdits2($word) 
    {
        $known = array();
        foreach ($this->edits1($word) as $e1) {
            foreach ($this->edits1($e1) as $e2) {
                if (array_key_exists($e2, $this->NWORDS)) 
                    $known[] = $e2;
            }
        }
        return array_unique($known);
    }

    /**
     * Given a list of words, returns the subset that is present on the dictionary. This may return duplicates, so
     * array_unique() is called on the return array.
     *
     * @param array $words
     * @return array
     */
    protected function known(array $words) 
    {
        $known = array();
        foreach ($words as $w) {
            $lw = strtolower($w);
            if (array_key_exists($lw, $this->NWORDS)) {
                $known[] = $w;
            }
        }
        return array_unique($known);
    }

    /**
     * Returns whether the word is already in the dictionary
     * 
     * @param  [string] $word [the word to check]
     * @return [boolean]        [true if known, false if not known]
     */
    protected function wordIsKnown($word) 
    {
        if ($word == "" || empty($word)) return false;
        if (empty($this->NWORDS)) return false;

        $lw = strtolower($word);

        return (array_key_exists($lw, $this->NWORDS));
    }

    /**
     * Serialises the dictionary to a text file.
     * 
     * @return [type] [description]
     */
    protected function serialiseDictionary($forced = false)
    {
        $file_doesnt_exist = (!file_exists($this->file));
        $file_exists_force = (file_exists($this->file) && $forced === true);

        if ($file_doesnt_exist || $file_exists_force) {
            $this->NWORDS = $this->train($this->words(file_get_contents($this->wordFile)));
            $fp = fopen($this->file,"w+");
            fwrite($fp, serialize($this->NWORDS));
            fclose($fp);

            return true;
        } else
            return false;
    }

    /**
     * Returns the list of candidate words that are present on the dictionary that are most similar (and relevant) to the
     * word passed as a parameter ($word).
     *
     * @param string $word
     * @return [array] of candidate spellings for the word
     */
    protected function correct($word) 
    {
        $no_corrections = 'Sorry, no corrections!';
        if (!is_string($word)) return false;

        $word = trim($word);
        if (empty($word)) return false;
        
        // $word = strtolower($word);
        
        if (empty($this->NWORDS)) {
            
            /* To optimize performance, the serialized dictionary can be saved on a file instead of parsing every single execution */
            if (!file_exists($this->file)) {
                $this->serialiseDictionary();
            } else {
                $this->NWORDS = unserialize(file_get_contents($this->file));
            }
        }

        $candidates = array(); 

        if ($this->known(array($word))) {
            return array($word);
        } elseif (($tmp_candidates = $this->known($this->edits1($word)))) {
            foreach ($tmp_candidates as $candidate) {
                $candidates[] = $candidate;
            }
        } elseif (($tmp_candidates = $this->knownEdits2($word))) {
            foreach ($tmp_candidates as $candidate) {
                $candidates[] = $candidate;
            }
        } else {
            return array($word);
        }

        // $max = 0;
        // foreach ($candidates as $c) {
        //     $value = $this->NWORDS[$c];
        //     if ($value > $max) {
        //         $max = $value;
        //         $word = $c;
        //     }
        // }

        return $candidates;
    }
}
