<?php

abstract class Logable
{
    protected $msg;
    protected $logmsg;
    protected $trigger;

    public abstract function toString();

    public function toLog()
    {
        $this->logmsg = $this->logmsg == null ? $this->msg : $this->logmsg;
        return new Log($this);
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getLogMsg()
    {
        return $this->logmsg;
    }

    public function getTrigger()
    {
        return $this->trigger;
    }

    public abstract function getSymbol();
}

?>