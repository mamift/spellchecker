<?php

class SerialiseDictionary extends SpellCheckCommand
{
    private $forced;
    private $debugInfo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($forced)
    {
        parent::__construct();

        $this->forced = $forced;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $exceptionOccured = false;
        try {
            $this->debugInfo = $this->serialiseDictionary($this->forced);
        } catch (Exception $e) {
            $exceptionOccured = true;
        }

        if ($exceptionOccured) {
            $success = false;
            $message = GENERIC_FAIL;
        } else {
            $success = true;
            $message = DICTIONARY_SERIALISED;
        }

        return results($this->debugInfo, $success, $message);
    }
}
