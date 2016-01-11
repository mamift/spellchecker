<?php

class SpellCheckWord extends SpellCheckCommand
{
    private $word;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($word)
    {
        parent::__construct();

        $this->word = $word;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $candidates = $this->correct($this->word);
        $wasKnown = $this->wordIsKnown($this->word);

        $success = true;
        $message = SPELLCHECK_SUCCESS;

        $count = count($candidates);
        
        if ($count == 1 && strcmp($candidates[0], $this->word) == 0) {
            $success = false;

            $message = ($wasKnown ? SPELLCHECK_KNOWN_WORD : SPELLCHECK_NO_SUGGESTIONS);
        }

        return results($candidates, $success, $message);
    }
}
