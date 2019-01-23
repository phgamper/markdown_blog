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
        // $fh = fopen($this->logfile, 'a');
        $fh = fopen('php://stdout', 'w');
        if ($fh) {
            foreach ($this->logs as $log) {
                if (! fwrite($fh, $log->toString())) {
                    self::add(
                        new Fault('Can\'t write to Logfile: '.$this->logfile, 'Logger::writeLog( )'));
                    return;
                }
            }
            $this->logs = array();
            fclose($fh);
        } else {
            self::add(new Fault('Can\'t open Logfile: '.$this->logfile, 'Logger::writeLog( )'));
        }
    }

    /**
     * generate a HTML string to output all alerts logged by the logger
     *
     * @return string to print
     */
    public function toString() {
        $string = '';
        if ($ret = self::alertBlock('Info')) {
            $string .= $ret;
            $class = 'info';
        }
        if ($ret = self::alertBlock('Success')) {
            $string .= $ret;
            $class = 'success';
        }
        if ($ret = self::alertBlock('Warning')) {
            $string .= $ret;
            $class = 'warning';
        }
        if ($ret = self::alertBlock('Error')) {
            $string .= $ret;
            $class = 'danger';
        }
        if (!empty($string)) {
            Script::getInstance()->inline("$('#modal-logger').modal('show');");
        $string = <<< HTML
    <div class="modal fade" id="modal-logger" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content alert-$class">
                <div class="modal-header hidden-sm hidden-md hidden-lg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>$string</p>
                </div>
            </div>
        </div>
    </div>
HTML;
        }
        return $string;
    }

    /**
     * prints an alert block in the colour according to the given alert type
     *
     * @param string $alert type passed
     * @return string to print
     */
    private function alertBlock($alert) {
        $string = '';
        if (! empty($this->messages)) {
            foreach ($this->messages as $key => $msg) {
                if ($msg instanceof $alert) {
                    $string .= '<li>' . $msg->toString() . '</li>';
                    unset($this->messages[$key]);
                }
            }
        }
        return empty($string) ? false : $string;
    }
}
