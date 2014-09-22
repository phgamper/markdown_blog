<?php

class Warning extends Logable
{
    const SYMBOL = '(WW)';

    public function __construct($msg, $trigger, $logmsg = NULL)
    {
        $this->msg = $msg;
        $this->trigger = $trigger;
        $this->logmsg = $logmsg;
    }

    public function toString()
    {
        return '<strong>Warning!</strong> ' . $this->msg;
    }

    public function getSymbol()
    {
        return self::SYMBOL;
    }
}

?>