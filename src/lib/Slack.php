<?php

/**
 * This file is part of the MarkdownBlog project.
 * TODO ...
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
class Slack {

    private $user = 'MD Blog';
    private $url;
    private $channel;

    private static $instance = null;

    private function __clone() { }

    private function __construct()
    {
        $this->url = getenv('HOSTLI_SLACK_URL');
        $this->channel = getenv('HOSTLI_SLACK_MDBLOG_LOG');
    }

    /**
     * returns the instance created by its first invoke.
     *
     * @return Slack
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function notify($msg, $icon)
    {
        // send slack notification
        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_SSL_VERIFYPEER => TRUE,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(array('channel' => $this->channel, 'username' => $this->user, 'text' => $msg, 'icon_emoji' => $icon))
        ]);
        if (($response = curl_exec($ch)) === FALSE) {
            Logger::getInstance()->addLog((new Fault(curl_error($ch), 'Slack::notify'))->toLog());
        }
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setURL($url) {
        $this->url = $url;
    }

    function setChannel($channel) {
        $this->channel = $channel;
    }
}
