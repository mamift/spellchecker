<?php

class SpellCheckText extends IdentifyMispelltWords
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        parent::__construct($text);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        $this->buildCandidateWordsForUnknownWords();

        $this->words['unknown_candidates'] = $this->unknownCandidates;
        $this->words['unknown_no_candidates'] = $this->unknownButNoCandidates;
        
        return $this->words;
    }

    /**
     * Build a list of possible candidate corrections for each unknown word
     * Also list the words with no candidate (suggested) corrections
     */
    public function buildCandidateWordsForUnknownWords()
    {
        if (count($this->unknownWords) == 0 || empty($this->unknownWords)) return false;
        
        $this->unknownCandidates = array();
        $this->unknownButNoCandidates = array();

        foreach ($this->unknownWords as $w) {
            if (!is_array($w)) {
                $candidateCorrections = $this->correct($w);

                if (count($candidateCorrections) <= 1 && $candidateCorrections[0] == $w) {
                    $this->unknownButNoCandidates[] = $w;
                } else
                    $this->unknownCandidates[$w] = $candidateCorrections;
            }
        }

        return array('unknown_candidates' => $this->unknownCandidates, 'unknownButNoCandidates' => $this->unknownButNoCandidates);
    }
}
