<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the possibility to scan a given path and filter according to the given
 * criteria. 
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
class ScanDir
{

    private $directories = array();

    private $files = array();

    private $path;

    public function __construct($path = null)
    {
        $this->path = $path == null ? getcwd() : $path;
        self::scanDirectory();
    }

    private function scanDirectory()
    {
        try {
            if (is_dir($this->path)) {
                $scandir = scandir($this->path);
                
                foreach ($scandir as $item) {
                    switch (true) {
                        case ($item == '.'):
                            {
                                break;
                            }
                        case ($item == '..'):
                            {
                                break;
                            }
                        case (is_file($this->path . '/' . $item)):
                            {
                                $this->files[] = $item;
                                break;
                            }
                        case (is_dir($this->path . '/' . $item)):
                            {
                                $this->directories[] = $item;
                                break;
                            }
                    }
                }
            } else {
                // TODO
                Throw new Exception('Directory Not Found!');
            }
        } catch (Exception $e) {
            // TODO catch exception
        }
    }

    public static function getFilesOfType($path, $mime)
    {
        $scan = new self($path, $mime);
        $files = array();
        foreach ($scan->getFiles() as $f) {
            if ($mime == substr($f, - strlen($mime))) {
                $files[] = $f;
            }
        }
        return $files;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getDirectories()
    {
        return $this->directories;
    }
}

?>
