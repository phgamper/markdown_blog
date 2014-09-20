<?php

class Info extends Logable
{
    const SYMBOL = '(II)';

    public function __construct($msg, $trigger, $logmsg = NULL)
    {
        $this->msg = $msg;
        $this->trigger = $trigger;
        $this->logmsg = $logmsg;
    }

    public function toString()
    {
        return '<strong>Info:</strong> ' . $this->msg;
    }

    public function getSymbol()
    {
        return self::SYMBOL;
    }
}

?>