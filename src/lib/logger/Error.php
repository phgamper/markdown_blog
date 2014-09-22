<?php

class Error extends Logable
{
    const SYMBOL = '(EE)';

    public function __construct($msg, $trigger, $logmsg = NULL)
    {
        $this->msg = $msg;
        $this->trigger = $trigger;
        $this->logmsg = $logmsg;
    }

    public function toString()
    {
        return '<strong>Oh snap!</strong> ' . $this->msg;
    }

    public function getSymbol()
    {
        return self::SYMBOL;
    }
}

?>