<?php

/**
 * This file is part of the MarkdownBlog project.
 * The Logger is implemented as a singleton. It is responsible for logging 
 * different alerts. There are two different types of alerts: Log and Logable.
 * First are just logged into a file and not shown on screen, second are logged
 * into a file too but also shown on screen.
 * Is responsible for automatically loading requested PHP classes
 *
 * MarkdownBlog is a lightweight blog software written in php and twitter bootstrap.
 * Its purpose is to provide a easy way to share your thoughts without any Database
 * or special setup needed.
 *
 * Copyright (C) 2014 Philipp Gamper & Max Schrimpf
 *
 * The project is free software: You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The file is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with the project. if not, write to the Free Software Foundation, Inc.
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
class Logger
{
    private $logfile;
    private $messages = array();
    private $logs = array();
    private static $instance = null;

    private function __construct() {
        $this->logfile = ($env = getenv('APACHE_LOG_DIR')) ? $env.'/'.DEFAULT_LOG_FILE : LOG_DIR.DEFAULT_LOG_FILE;
    }

    private function __clone() {}

    /**
     * returns the instance created by its first invoke.
     *
     * @return Logger
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * adds a Logable to the message list
     *
     * @param Logable $l
     */
    public function add(Logable $l) {
        $this->messages[] = $l;
        self::addLog($l->toLog());
    }

    /**
     * adds a Log to the loglist
     *
     * @param Log $log to add
     */
    public function addLog(Log $log) {
        $this->logs[] = $log;
    }

    /**
     * empty the alert message list
     */
    public function flushMsgs() {
        $this->messages = array();
    }

    /**
     * writes all alerts into the logfile
     */
    public function writeLog() {
        $fh = fopen($this->logfile, 'a');
        if ($fh) {
            foreach ($this->logs as $log) {
                if (! fwrite($fh, $log->toString())) {
                    self::add(
                        new Error('Can\'t write to Logfile: '.$this->logfile, 'Logger::writeLog( )'));
                    return;
                }
            }
            $this->logs = array();
        } else {
            self::add(new Error('Can\'t open Logfile: '.$this->logfile, 'Logger::writeLog( )'));
        }
    }

    /**
     * generate a HTML string to output all alerts logged by the logger
     *
     * @return string to print
     */
    public function toString() {
        $string = self::alertBlock('Info', 'info');
        $string .= self::alertBlock('Success', 'success');
        $string .= self::alertBlock('Warning', 'warning');
        $string .= self::alertBlock('Error', 'danger');
        return $string;
    }

    /**
     * prints an alert block in the colour according to the given alert type
     *
     * @param string $alert type passed
     * @param string $class indicates which css class to use
     * @return string to print
     */
    private function alertBlock($alert, $class) {
        $has = false;
        $string = '';
        if (! empty($this->messages)) {
            $string .= '<div class="alert alert-'.$class.'" role="alert"><button type="button" class="close" data-dismiss="alert">x</button><ul>';
            foreach ($this->messages as $key => $msg) {
                if ($msg instanceof $alert) {
                    $has = true;
                    $string .= '<li>' . $msg->toString() . '</li>';
                    unset($this->messages[$key]);
                }
            }
            $string .= '</ul></div>';
        }
        return $has ? $string : '';
    }
}
