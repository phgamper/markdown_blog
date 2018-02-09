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
class PhotoSwipe extends AbstractModel implements ILeaf {

    // TODO multiple mimes
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
        $index = !isset($this->config['reverse']) || $this->config['reverse'] ? 1 : 0;
        return $visitor->photoSwipe($this, $index, $bool);
    }

    /**
     * This function loads all images contained in the folder stored in $this->path,
     * generate the bootstrap modal carousel and returns it.
     *
     * @param int $index
     * @return string generated carousel
     */
    public function parse($index) {
        $files = ScanDir::getFilesOfType($this->config['path'], self::MIME, $index);
        try {
            Head::getInstance()->link(PUBLIC_LIB_DIR . 'photoswipe/photoswipe.css');
            Head::getInstance()->link(PUBLIC_LIB_DIR . 'photoswipe/default-skin/default-skin.css');
            Script::getInstance()->link(PUBLIC_LIB_DIR . 'photoswipe/photoswipe.min.js');
            Script::getInstance()->link(PUBLIC_LIB_DIR . 'photoswipe/photoswipe-ui-default.min.js');
            Script::getInstance()->link(PUBLIC_LIB_DIR . 'photoswipe/init.js');
            $html = file_get_contents(PUBLIC_LIB_DIR . 'photoswipe/photoswipe.html');
            $items = '';
            foreach ($files as $f) {
                list($width, $height) = getimagesize($this->config['path'] . $f);
                $src = 'data-src="' . Config::getInstance()->app_root . $this->config['path'] . $f . '"';
                $width = 'data-width="' . $width . '"';
                $height = 'data-height="' . $height . '"';
                $items .= '<span ' . $src . $width . $height . '" class="img-swipe">';
            }

            return '<div class="hidden">' . $items . '</div>' . $html;
        } catch (Exception $e) {
            Logger::getInstance()->add(new Fault('An unexpected error has occurred.', 'PhotoSwipe::parse("' . $this->config['path'] . '")', $e->getMessage()));
            return '';
        }
    }
}
