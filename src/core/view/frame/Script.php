<?php

/**
 * This file is part of the MarkdownBlog project.
 * It works as a dynamic loader for the JavaScript files in the bottom of the page
 * to aviod unnecessary traffic.
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
class Script
{

    private $scripts = array();

    private $inlines = array();

    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {}

    /**
     * returns the instance created by its first invoke.
     *
     * @return Script
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * link a JS to the script list
     *
     * @param string $script path to js file
     * @param bool $abs link script using absolute path e.g. https:// ...
     */
    public function link($script, $abs = false)
    {
        $this->scripts[] = $abs ? $script : Config::getInstance()->app_root.$script;
    }

    /**
     * inlines a script directly into the HTML code
     *
     * @param $script script
     *            to inline
     */
    public function inline($script)
    {
        $this->inlines[] = $script;
    }

    /**
     * empty the script list
     */
    public function flush()
    {
        $this->scripts = array();
    }

    /**
     * generate the script list as a HTML string
     *
     * @return string to print
     */
    public function toString()
    {
        $js = '<!-- Le javascript -->';
        foreach ($this->scripts as $j) {
            $js .= '<script src="' . $j . '"></script>';
        }
        foreach ($this->inlines as $i) {
            $js .= '<script>' . $i . '</script>';
        }
        return $js;
    }
}
