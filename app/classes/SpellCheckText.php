<?php

class SpellCheckText extends SpellCheckCommand
{
    private $text;
    private $uniqueWords;
    private $knownWords;
    private $unknownWords;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        parent::__construct();

        $this->text = $text;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->extractUniqueWords();

        $this->buildKnownWordsList();

        $this->buildCandidateWordsForUnknownWords();

        $_words = array(
            'known' => $this->knownWords, 
            'unknown' => $this->unknownWords,
            'unknown_candidates' => $this->unknownCandidates,
            'unknown_no_candidates' => $this->unknownButNoCandidates
        );
        
        return $_words;
    }

    /**
     * Extract all unique words from the text
     */
    private function extractUniqueWords()
    {
        $words = explode(" ", $this->text);

        $this->uniqueWords = array_unique($words);

        foreach ($this->uniqueWords as &$w) {
            $w = strtolower($w);
        }
    }

    /**
     * Build known word list (these words are to be skipped over)
     */
    private function buildKnownWordsList()
    {
        $this->knownWords = array();
        $this->unknownWords = array();

        foreach ($this->uniqueWords as $w) {
            if ($this->wordIsKnown($w)) $this->knownWords[] = $w;
            else {
                $this->unknownWords[] = $w;
            }
        }
    }

    /**
     * Build a list of possible candidate corrections for each unknown word
     * Also list the words with no candidate (suggested) corrections
     */
    private function buildCandidateWordsForUnknownWords()
    {
        if (count($this->unknownWords) == 0 || empty($this->unknownWords)) return false;
        
        $this->unknownCandidates = array();
        $this->unknownButNoCandidates = array();

        foreach ($this->unknownWords as $w) {
            if (!is_array($w)) {
                $candidateCorrections = $this->correct($w);

                if (count($candidateCorrections) <= 1 && $candidateCorrections[0] == $w) {
                    $this->unknownButNoCandidates[$w] = false;  
                } else
                    $this->unknownCandidates[$w] = $candidateCorrections;
            }
        }
    }
}
