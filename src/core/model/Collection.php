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
class Collection extends Container implements ILeaf {

    public $models = [];

    public $start = 0;

    public function __construct($model, $config) {
        parent::__construct($config);

        $files = ScanDir::getFilesOfType($this->config['path'], $model::MIME, !isset($config['reverse']) || $config['reverse']);
        $this->count = count($files);
        $this->limit = isset($config['limit']) ? $config['limit'] : $this->count;
        $static = isset($config['static']) ? $config['static'] : true;
        foreach ($files as $i => $f) {
            $model = new $model(['name' => $f, 'path' => $config['path'] . $f, 'type' => $config['type'], 'static' => $static]);
            $this->addModel($model, $i);
        }
    }

    /**
     *
     *
     * @param IVisitor $visitor
     * @param mixed $arg
     * @param boolean $bool
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg, $bool) {
        return $visitor->collection($this, $arg, $bool);
    }
}
