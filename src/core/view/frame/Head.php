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
    
    private static $instance = null;
    
    private function __construct()
    {
        $ini = parse_ini_file(CONFIG_DIR.'general.ini', true);
        
        if(isset($ini['head']))
        {
            $this->config = $ini['head']; 
        } 
    }
    
    private function __clone()
    {
    }
    
    /**
     * returns the instance created by its first invoke.
     *
     * @return Head
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
     * link a CSS to the style sheet list
     *
     * @param $href path to css file
     * @param $rel  type of how to link the css
     */
    public function link($href, $rel = 'stylesheet')
    {
        $this->sheets[$href] = $rel;
    }
    
    /**
     * empty the style sheets list
     */
    public function flush()
    {
        $this->sheets = array();
    }

    /**
     * generate the head as a HTML string 
     *
     * @return string to print
     */
    public function toString()
    {
        $css = '';
        $site = isset($_GET['module']) ? ' - '. $_GET['module']: '';
        $title = '<title>'.$this->config['title'].$site.'</title>';
        $meta = '<meta charset="utf-8">'.$title.'<meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content=""><meta name="author" content="">';
        foreach ($this->sheets as $href => $rel)
        {
            $css .= '<link href="'.$href.'" rel="'.$rel.'">';
        }  
        if(isset($this->config['favicon']))
        {
            $css .= '<link href="'.$this->config['favicon'].'" rel="icon" type="image/png">';
        }        
        $string = '<head>'.$meta.$css.'</head>';        
        return $string; 
    }
}

?>
