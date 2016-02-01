<?php

class IdentifyMispelltWords extends SpellCheckCommand
{
    
    protected $text;
    public function getText() { return $this->text; }
    protected $uniqueWords;
    public function getUniquewords() { return $this->uniqueWords; }
    protected $knownWords;
    public function getKnownwords() { return $this->knownWords; }
    protected $unknownWords;
    public function getUnknownwords() { return $this->unknownWords; }
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($text)
    {
        parent::__construct();

        if (!empty_or_notset($text)) {
            $this->text = $text;
            $this->extractUniqueWords();
        } else {
            exception('IdentifyMispelltWords', 'No text supplied for checking!');
        }
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->buildKnownWordsList();
        $this->buildUnknownWordsList();

        $this->words = array(
            'known' => $this->knownWords, 
            'unknown' => $this->unknownWords
        );
        
        return $this->words;
    }

    /**
     * Extract all unique words from the text
     */
    public function extractUniqueWords()
    {
        $words = explode(" ", $this->text);

        $this->uniqueWords = array_unique($words);

        foreach ($this->uniqueWords as &$w) {
            $w = strtolower($w);
        }

        return $this->uniqueWords;
    }

    /**
     * Build known word list 
     */
    public function buildKnownWordsList()
    {
        $this->knownWords = array();

        foreach ($this->uniqueWords as $w) {
            if ($this->wordIsKnown($w)) $this->knownWords[] = $w;
        }

        return $this->knownWords;
    }

    /**
     * Build unknown word list
     */
    public function buildUnknownWordsList() 
    {
        $this->unknownWords = array();

        foreach ($this->uniqueWords as $w) {
            if (!$this->wordIsKnown($w)) $this->unknownWords[] = $w;
        }

        return $this->unknownWords;
    }
}
