<?php

abstract class Command 
{
    protected $delegateMethodHandler = "";

    /**
     * Sets the delegate method handler via a string
     * 
     * @param  [string] $delegate [the name of the method on 
     * the delegate class; does not have to be public]
     */
    public function setDelegate($delegate)
    {   
        $this->delegateMethodHandler = $delegate;
    }

    /**
     * Invoke the delegate method handler on this class
     * 
     * @return [type] [description]
     */
    public function callDelegate()
    {
        if (empty_or_notset($this->delegateMethodHandler)) return exception('DELEGATION_NOHANDLER_SET', DELEGATION_NOHANDLER_SET);

        if (!method_exists($this, $this->delegateMethodHandler)) return exception('DELEGATION_ERROR_NOMETHOD', DELEGATION_ERROR_NOMETHOD);

        return $this->delegateMethodHandler();
    }
}