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
class Config
{
    public $general;

    public $config;

    public $app_root;

    private static $instance = null;

    private function __construct()
    {
        $this->general = IniParser::parseMerged(array(
            SRC_DIR.'defaults.ini',
            CONFIG_DIR.'general.ini'
        ));

        if (file_exists(CONFIG_DIR.'config.ini')) {
            $this->parser = new IniParser();
            $this->parser->use_array_object = false;
            $this->config = $this->parser->parse(CONFIG_DIR.'config.ini');
        }
        $this->app_root = $this->general['general']['app_root'];
    }

    private function __clone() {}

    /**
     * returns the instance created by its first invoke.
     *
     * @return Config
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * returns the item of config array according to the given key if exists
     * returns an empty array() otherwise
     *
     * @param $key of the array element
     * @return array
     */
    public function getConfigItem($key){
        return array_key_exists($key, $this->config) ? $this->config[$key] : array();
    }

    /**
     * returns the item of general array according to the given key if exists
     * returns an empty array() otherwise
     *
     * @param $key of the array element
     * @return array
     */
    public function getGeneralItem($key){
        return array_key_exists($key, $this->general) ? $this->general[$key] : array();
    }
}
?>
