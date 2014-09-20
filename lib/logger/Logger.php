<?php

/**
 * The Logger is implemented as a singleton. It is responsible for logging 
 * different alerts. There are two different types of alerts: Log and Logable.
 * First are just logged into a file and not shown on screen, second are logged
 * into a file too but also shown on screen.
 */
class Logger
{
    private $msgs = array();
    private $logs = array();
    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * returns the instance created by its first invoke.
     *
     * @return Logger
     */
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * adds a Logable to the message list
     *
     * @param Logable $l            
     */
    public function add(Logable $l)
    {
        $this->msgs[] = $l;
        self::addLog($l->toLog());
    }

    /**
     * adds a Log to the loglist
     *
     * @param Log $log to add
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;
    }

    /**
     * empty the alert message list
     */
    public function flushMsgs()
    {
        $this->msgs = array();
    }

    /**
     * writes all alerts into the logfile
     */
    public function writeLog()
    {
        $fh = fopen(LOG_DIR . DEFAULT_LOG_FILE, 'a');
        
        if ($fh)
        {
            foreach ($this->logs as $log)
            {
                if (!fwrite($fh, $log->toString()))
                {
                    self::add(
                        new Error('Can\'t write to Logfile: ' . LOG_DIR . DEFAULT_LOG_FILE, 'Logger::writeLog( )'));
                    return;
                }
            }
            
            $this->logs = array();
        }
        else
        {
            self::add(new Error('Can\'t open Logfile: ' . LOG_DIR . DEFAULT_LOG_FILE, 'Logger::writeLog( )'));
        }
    }

    /**
     * generate a HTML string to output all alerts logged by the logger
     *
     * @return string to print
     */
    public function toString()
    {
        $string = self::alertblock('Info');
        $string .= self::alertblock('Success');
        $string .= self::alertblock('Warning');
        $string .= self::alertblock('Error');
        return $string;
    }

    /**
     * prints an alert block in the colour according to the given alert type
     *
     * @param string $alert
     *            type passed
     * @return string to print
     */
    private function alertblock($alert)
    {
        $has = false;
        $string = '';
        
        if (!empty($this->msgs))
        {
            $string .= '<div class="alert alert-' . strtolower($alert) .
                 ' alert-block"><button type="button" class="close" data-dismiss="alert">x</button><ul>';
            
            foreach ($this->msgs as $key => $msg)
            {
                if ($msg instanceof $alert)
                {
                    $has = true;
                    $string .= '<li>' . $msg->toString() . '</li>';
                    unset($this->msgs[$key]);
                }
            }
            
            $string .= '</ul></div>';
        }
        return $has ? $string : '';
    }
}

?>