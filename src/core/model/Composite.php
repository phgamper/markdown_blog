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
class Composite extends Container {

    public $models = [];

    /**
     *
     *
     * @param IVisitor $visitor
     * @param mixed $arg
     * @param boolean $bool
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg, $bool) {
        return $visitor->composite($this, $arg, $bool);
    }

    /**
     *
     * @param AbstractModel $model to add
     * @param string $key
     */
    public function addModel(AbstractModel $model, $key) {
        $this->count++;
        $this->limit++;
        parent::addModel($model, $key);
    }

    public function get() {
        return $this->models;
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param int $index - index of parsed element
     * @return string parsed image
     */
    public function parse($index) {
        return '';
    }
}
