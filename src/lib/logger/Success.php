<?php

class Success extends Logable
{
    const SYMBOL = '(**)';

    public function __construct($msg, $trigger, $logmsg = NULL)
    {
        $this->msg = $msg;
        $this->trigger = $trigger;
        $this->logmsg = $logmsg;
    }

    public function toString()
    {
        return '<strong>Done!</strong> ' . $this->msg;
    }

    public function getSymbol()
    {
        return self::SYMBOL;
    }
}

?>