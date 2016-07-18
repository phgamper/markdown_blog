<?php

/**
 * This file is part of the MarkdownBlog project.
 * TODO
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
class Remote extends Markdown {

    const MIME = '.md';

    /**
     *
     *
     * @param IVisitor $visitor
     * @param mixed $arg
     * @param boolean $bool
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg, $bool) {
        return $visitor->remote($this, $arg, $bool);
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param int $index - index of parsed element
     * @return string parsed Markdown
     */
    public function parse($index) {
        try {
            if ($file = file_get_contents($this->config['path'])) {
                return Parsedown::instance()->text($file);
            } else {
                throw new Exception('Can not read ' . $this->config['path']);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'Remote::parse("' . $this->config['path'] . '")', $e->getMessage()));
            return '';
        }
    }
}
