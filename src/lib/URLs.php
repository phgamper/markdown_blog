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
class URLs {

    private $base;
    private $utf8;
    private $uri;
    private $parts;

    private static $instance = null;

    private function __construct() {
        self::parseURI();
    }

    private function __clone() {
    }

    /**
     * returns the instance created by its first invoke.
     *
     * @return URLs
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * TODO
     */
    public function parseURI() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $request = explode('?', $_SERVER['REQUEST_URI']);
            $this->base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
            $this->utf8 = substr(urldecode($request[0]), strlen($this->base) + 1);
            $this->uri = utf8_decode($this->utf8);
            if ($this->uri == basename($_SERVER['PHP_SELF'])) {
                $this->uri = '';
            }
            $this->parts = explode('/', $this->uri);
        }
    }

    /**
     * TODO
     * @param int $level
     * @return string
     */
    public function module($level = 0) {
        return !array_key_exists($level, $this->parts) || $this->parts[$level] == '' ? Config::getInstance()->getGeneral('general', 'default_home') : strtolower($this->parts[$level]);
    }

    public function getURI() {
        return $this->uri == '' ? Config::getInstance()->getGeneral('general', 'default_home') : rtrim($this->uri, "/");
    }

    public function level($level) {
        return array_key_exists($level, $this->parts) ? $this->parts[$level] : false;
    }

    public function isRaw() {
        return $this->module() == 'raw';
    }
    
    public function isPlugin() {
        return Config::getInstance()->hasPlugin($this->module());
    }
}

