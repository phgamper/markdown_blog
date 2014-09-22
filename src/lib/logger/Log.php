<?php

class Log
{
    public $msg;
    public $TSP;
    public $alert;
    public $trigger;

    public function __construct(Logable $l)
    {
        $this->TSP = date('YmdHms');
        $this->msg = $l->getLogMsg();
        $this->trigger = $l->getTrigger();
        $this->alert = $l->getSymbol();
    }

    public function toString()
    {
        return "$this->TSP:\t$this->alert\t$this->trigger\t$this->msg\n";
    }
}

?>