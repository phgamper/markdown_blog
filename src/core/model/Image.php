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
class Image extends AbstractModel implements ILeaf {

    // TODO support multiple mimes
    const MIME = '.jpg';

    /**
     *
     *
     * @param IVisitor $visitor
     * @param mixed $arg
     * @param boolean $bool
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg, $bool) {
        return $visitor->image($this, $arg, $bool);
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param int $index - index of parsed element
     * @return string parsed image
     */
    public function parse($index) {
        try {
            $src = 'src="' . Config::getInstance()->app_root . $this->config['path'] . '"';
            if (Config::getInstance()->getGeneral('general', 'img_resize')) {
                $src = 'src="/img/loader.gif" data-' . $src;
            }
            $img = '<img index=' . $index . ' ' . $src . ' class="owl-jumpTo">';
            // TODO move link to modal or use $index for case distinction
            $a = '<a href="" data-toggle="modal" data-target="#carousel-modal" data-index="' . $index . '">' . $img . '</a>';
            return '<div class="thumbnail img-resize">' . $a . '</div>';
        } catch (Exception $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'Image::parse("' . $this->config['path'] . '")', $e->getMessage()));
            return '';
        }
    }
}
