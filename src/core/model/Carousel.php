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
class Carousel extends AbstractModel
{
    // TODO multiple mimes
    public $mime = '.jpg';

    /**
     *
     *
     * @param IVisitor $visitor
     * @param $arg
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg){
        return $visitor->carousel($this, $arg);
    }

    /**
     * This function loads all images contained in the folder stored in $this->path,
     * generate the bootstrap modal carousel and returns it.
     *
     * @param int $index
     * @return string generated carousel
     */
    public function parse($index)
    {
        $files = ScanDir::getFilesOfType($this->path, $this->mime, $index);
        try {
            Head::getInstance()->link('lib/owl-carousel/css/owl.carousel.css');
            Head::getInstance()->link('lib/owl-carousel/css/owl.theme.css');
            Script::getInstance()->link('lib/owl-carousel/js/owl.carousel.js');
            Head::getInstance()->link('lib/owl-carousel/css/lazy_load.css');
            Script::getInstance()->link('lib/owl-carousel/js/lazy_load.js');
            $items = '';
            foreach ($files as $f){
                $items .= '<div class="item"><img class="lazyOwl" data-src="'.Config::getInstance()->app_root.$this->path.$f.'" /></div>';
            }
            return '<div id="carousel" class="owl-carousel owl-theme">'.$items.'</div>';
        } catch (Exception $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'Markdown::carousel( ... )', $e->getMessage()));
            return '';
        }
    }
}
