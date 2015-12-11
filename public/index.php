<?php

/**
 * This file is part of the MarkdownBlog project.
 * It is the entry page for the project and is responsible for the proper loading
 * of all needed libraries.
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



include_once ('../src/config.php');
include_once (LIB_DIR . 'Autoload.php');
include_once (LIB_DIR . 'ScanDir.php');
ini_set('display_errors', 1);
$src = Autoload::getInstance(SRC_DIR, false)->getClasses();
$lib = Autoload::getInstance(LIB_DIR, false)->getClasses();
$classes = array_merge($src, $lib);
set_error_handler("error_handler", E_ALL);

/**
 * Parse REQUEST_URI to enable pretty URLS
 */
URLs::getInstance()->parseURI();

/**
 * setup page and load provided business-casual.php
 */
$config = Config::getInstance()->getGeneralArray('general');
if (isset($config['highlight']) && $config['highlight']) {
    $style = isset($config['scheme']) ? $config['scheme'] : 'default.css';
    Head::getInstance()->link(PUBLIC_LIB_DIR.'prismjs/css/'.$style);
    Script::getInstance()->link(PUBLIC_LIB_DIR.'prismjs/js/prism.js');
}

if (array_key_exists('img_resize', $config) && $config['img_resize']){
    Script::getInstance()->link('image.js');
}

Head::getInstance()->link(PUBLIC_LIB_DIR.'bootstrap/css/bootstrap.min.css');
Head::getInstance()->link(PUBLIC_LIB_DIR.'font-awesome/css/font-awesome.min.css');

// Add jquery and bootstrap into header so included HTML pages can use the libs
Head::getInstance()->linkScript(PUBLIC_LIB_DIR.'jquery/js/jquery.min.js');
Head::getInstance()->linkScript(PUBLIC_LIB_DIR.'bootstrap/js/bootstrap.js');

$container = new Controller();
$navigation = new NavigationController();
//$footer = new FooterController(new Sitemap($configfile));

if(($template = Config::getInstance()->getGeneral('general', 'template'))){
    include_once(TEMPLATES_DIR.$template);
}

/**
 * Function to autoload classes
 *
 * @param $class Class to load
 */
function __autoload($class)
{
    global $classes;
    include_once ($classes[$class]);
}

// TODO maybe not how it should be done ...
function error_handler($errno, $errstr, $errfile, $errline)
{
    switch ($errno)
    {
        case E_NOTICE:
        {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
            break;
        }
        default:
        {
            $msg = $errno . ' - ' . $errstr . ' - ' . $errfile . ' - ' . $errline;
            Logger::getInstance()->addLog(new Log(new Error('An unexpected error has been caught by the error_handler.', 'index.php::error_handler()', $msg)));
        }
    }
}

?>
