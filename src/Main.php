<?php

/**
 * This file is part of the MarkdownBlog project.
 * It sets up the backend and instanciates all needed components.
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

class Main
{

    public function __construct()
    {
        $ini = parse_ini_file(CONFIG_DIR . 'general.ini', true);
        $config = isset($ini['general']) ? $ini['general'] : array();
        
        Head::getInstance()->link('public/bootstrap/css/bootstrap.min.css');
        Head::getInstance()->link(CSS_DIR.'style.css');
        Script::getInstance()->link('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
        Script::getInstance()->link('public/bootstrap/js/bootstrap.js');
        if(isset($config['highlight']) && $config['highlight'])
        {
            $style = isset($config['scheme']) ? $config['scheme'] : 'default.css';
            Head::getInstance()->link(CSS_DIR.'scheme/'.$style);
            Script::getInstance()->link('public/js/highlight.js');
            Script::getInstance()->inline('$(document).ready(function() {$(\'pre code\').each(function(i, block) {hljs.highlightBlock(block);});});');
        }
        $navigation = new NavigationController(new IniNavigation(CONFIG_DIR.'config.ini'));
        $controller = new Controller();
        

        // display all
        $string = '';
        $string = $navigation->display();
        $string .= $controller->display();
        $head = Head::getInstance()->toString();
        $script = Script::getInstance()->toString();
        //include FRAME_ROOT_PATH . 'script.php';
        echo '<!DOCTYPE html><html lang="en">'.$head.'<body>'.$string.$script.'</body></html>';
    }
}

?>
