<?php

/**
 * This file is part of the MarkdownBlog project.
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
final class Autoload
{

    private static $instance = NULL;

    private $classes = array();

    private function __construct()
    {
        self::import(LIB_DIR);
        self::import(str_replace('//', '/', SRC_DIR));
    }

    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    public function import($path)
    {
        $ScanDir = new ScanDir($path);
        self::addClasses($ScanDir->getFiles(), $path);
        
        foreach ($ScanDir->getDirectories() as $dir) {
            self::import($path . $dir . "/");
        }
    }

    private function addClasses($files, $path)
    {
        if ($files) {
            foreach ($files as $file) {
                if (substr($file, - 4) == '.php') {
                    $classname = substr($file, 0, - 4);
                    $this->classes[$classname] = $path . $file;
                }
            }
        }
    }

    public function getClasses()
    {
        return $this->classes;
    }
}

?>