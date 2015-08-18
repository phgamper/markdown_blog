<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the central part of the application and is responsible for loading 
 * and parsing the image files.
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
class Image extends AbstractModel
{

    public $path;

    public $count = 0;

    public function __construct($path)
    {
        parent::__construct($path, '.jpg');
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param unknown $file
     *            - file to parse
     * @return parsed image
     */
    public function parse($file)
    {
        try {
            $photo = HTMLBuilder::a_img($file, $file, '', false, 'data-gallery="gallery"');
            $photo = '<div class="thumbnail">' . $photo . '</div>';
            return $photo;
        } catch (Exception $e) {
            Logger::getInstance()->add(
                new Error('An unexpected error has occurred.', 'Markdown::parse("' . $file . '")'), $e->getMessage());
            return '';
        }
    }


    /**
     * This function loads all images contained in the folder stored in $this->path,
     * generate the bootstrap modal carousel and returns it.
     *
     * @param unknown $reverse specify whether to build the carousel in reverse order or not
     *
     * @return generated carousel
     */
    public function carousel($reverse = true)
    {
        $files = ScanDir::getFilesOfType($this->path, $this->mime);
        $this->count = count($files);
        if($reverse)
        {
            rsort($files);
        }
        foreach ($files as &$f) {
            $f = $this->path.$f;
        }
        try {
            return HTMLBuilder::carousel($files);
        } catch (Exception $e) {
            Logger::getInstance()->add(
                new Error('An unexpected error has occurred.', 'Markdown::carousel( ... )'), $e->getMessage());
            return '';
        }

    }
}

?>

