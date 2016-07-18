<?php

/**
 * This file is part of the MarkdownBlog project.
 * It works as a dynamic loader for the CSS files and other header items to aviod
 * unnecessary traffic.
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
class Head {

    private $config;
    private $sheets = [];
    private $meta = [];
    private $scripts = [];
    private $og = [];
    private $title = '';

    private static $instance = null;

    private function __construct() {
        $this->config = Config::getInstance()->getGeneralArray('head');
        self::setTitle($this->config['title']);
        // default meta tags
        self::addMeta('description', $this->config['description']);
        if (isset($this->config['meta'])) {
            foreach ($this->config['meta'] as $k => $v) {
                self::addMeta($k, $v);
            }
        }
        // default og tags
        self::addOg('title', $this->title);
        self::addOg('description', $this->config['description']);
        self::addOg('url', 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        self::addOg('image', $this->config['image']);
        self::addOg('type', 'website');
    }

    private function __clone() {
    }

    /**
     * returns the instance created by its first invoke.
     *
     * @return Head
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $title to set
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string title of the page
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * links a CSS to the style sheet list
     *
     * @param string $href path to css file
     * @param string $rel type of how to link the css
     * @param bool $abs link css using absolute path e.g. https:// ...
     */
    public function link($href, $rel = 'stylesheet', $abs = false) {
        if ($abs) {
            $this->sheets[$href] = $rel;
        } else {
            $this->sheets[Config::getInstance()->app_root . $href] = $rel;
        }
    }

    /**
     * empties the style sheets list
     */
    public function flush() {
        $this->sheets = [];
    }

    /**
     * adds an og tag to the HTML head
     *
     * @param string $name - name of the og tag
     * @param string $content - content of the og tag
     */
    public function addOg($name, $content) {
        $this->og[$name] = $content;
    }

    /**
     * empties the og tag list
     */
    public function flushOg() {
        $this->og = [];
    }

    /**
     * adds an og tag to the HTML head
     *
     * @param string $name - name of the meta tag
     * @param string $content - content of the meta tag
     */
    public function addMeta($name, $content) {
        $this->meta[$name] = $content;
    }

    /**
     * empties the meta tag list
     */
    public function flushMeta() {
        $this->meta = [];
    }

    /**
     * link a JS to the script list from local or remote source
     *
     * @param string $script path to js file
     * @param bool $abs link script using absolute path e.g. https:// ...
     */
    public function linkScript($script, $abs = false) {
        $this->scripts[] = $abs ? $script : Config::getInstance()->app_root . $script;
    }

    /**
     * empty the script list
     */
    public function flushScript() {
        $this->scripts = [];
    }

    /**
     * return the og tags as a HTML string
     *
     * @return string to print
     */
    public function og() {
        $og = '';
        foreach ($this->og as $name => $content) {
            $og .= '<meta property="og:' . $name . '" content="' . $content . '">';
        }
        return $og;
    }

    /**
     * return the meta tags as a HTML string
     *
     * @return string to print
     */
    public function meta() {
        $meta = '<meta charset="utf-8">';
        foreach ($this->meta as $name => $content) {
            $meta .= '<meta name="' . $name . '" content="' . $content . '">';
        }
        return $meta;
    }

    /**
     * return the link tags as a HTML string
     *
     * @return string to print
     */
    public function css() {
        $css = '';
        foreach ($this->sheets as $href => $rel) {
            $css .= '<link href="' . $href . '" rel="' . $rel . '" type="text/css">';
        }
        return $css;
    }

    /**
     * return the script tags as a HTML string
     *
     * @return string to print
     */
    public function javascript() {
        $js = '';
        foreach ($this->scripts as $j) {
            $js .= '<script src="' . $j . '"></script>';
        }
        return $js;
    }

    /**
     * generate the head as a HTML string
     *
     * @return string to print
     */
    public function toString() {
        return $this->meta() . '<title>' . $this->title . '</title>' . $this->og() . $this->css() . $this->javascript();
    }
}

