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
class Head
{

    private $config;

    private $sheets = array();

    private $meta = array();

    private $scripts = array();

    private static $instance = null;

    private function __construct()
    {
        $ini = IniParser::parseMerged(array(
            SRC_DIR . 'defaults.ini',
            CONFIG_DIR . 'general.ini'
        ));
        if (isset($ini['head'])) {
            $this->config = $ini['head'];
        }
        if (isset($this->config['meta'])) {
            foreach ($this->config['meta'] as $k => $v) {
                self::addMeta($k, $v);
            }
        }
    }

    private function __clone()
    {}

    /**
     * returns the instance created by its first invoke.
     *
     * @return Head
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * links a CSS to the style sheet list
     *
     * @param $href path
     *            to css file
     * @param $rel type
     *            of how to link the css
     */
    public function link($href, $rel = 'stylesheet')
    {
        $this->sheets[$href] = $rel;
    }

    /**
     * empties the style sheets list
     */
    public function flush()
    {
        $this->sheets = array();
    }

    /**
     * adds an meta tag to the HTML head
     *
     * @param unknown $name
     *            - name of the meta tag
     * @param unknown $content
     *            - content of the meta tag
     */
    public function addMeta($name, $content)
    {
        $this->meta[$name] = $content;
    }

    /**
     * empties the meta tag list
     */
    public function flushMeta()
    {
        $this->meta = array();
    }

    /**
     * link a JS to the script list
     *
     * @param $script path
     *            to js file
     */
    public function linkScript($script)
    {
        $this->scripts[] = $script;
    }

    /**
     * empty the script list
     */
    public function flushScript()
    {
        $this->scripts = array();
    }

    /**
     * generate the head as a HTML string
     *
     * @return string to print
     */
    public function toString()
    {
        $css = '';
        $site = isset($_GET['module']) ? ' - ' . urlencode($_GET['module']) : '';
        $title = '<title>' . $this->config['title'] . $site . '</title>';
        $meta = '<meta charset="utf-8">' . $title;
        foreach ($this->meta as $name => $content) {
            $meta .= '<meta name="' . $name . '" content="' . $content . '">';
        }
        foreach ($this->sheets as $href => $rel) {
            $css .= '<link href="' . $href . '" rel="' . $rel . '" type="text/css">';
        }
        if (isset($this->config['favicon'])) {
            $css .= '<link href="' . $this->config['favicon'] . '" rel="icon" type="image/png">';
        }
        $js = '';
        foreach ($this->scripts as $j) {
            $js .= '<script src="' . $j . '"></script>';
        }
        $string = '<head>' . $meta . $css . $js . '</head>';
        return $string;
    }
}

?>
