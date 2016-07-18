<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides a view that displays formatted markdown/html files as a list.
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
class FloatingNavigationView extends AbstractNavigationView {

    // FIXME: private $active = "active";
    // TODO remove ...
    private $active = "";
    
    /**
     * FloatingNavigationView constructor.
     * 
     * @param Container $model
     */
    public function __construct(Container $model) {
        parent::__construct($model,  true);
    }

    /**
     * @param Container $model
     * @param int $arg
     * @param $bool
     * @return mixed|string
     */
    public function container(Container $model, $arg, $bool) {
        return $this::li($model, $arg, $this->anchor);
    }

    /**
     * @param AbstractModel $model
     * @param mixed $arg
     * @param bool $anchor
     * @return string
     */
    protected function li(AbstractModel $model, $arg, $anchor) {
        return '<li ' . $this->active($arg) . '><a class="page-scroll" href="' . $this->prefix($arg, $anchor) . $arg . '">' . $model->config['name'] . '</a></li>';
    }

    /**
     * @param $arg
     * @return string
     */
    protected function active($arg) {
        $a = URLs::getInstance()->isRaw() ? '' : 'class="' . $this->active . '"';
        $this->config[0]; // TODO
        $this->active = '';
        return $a;
    }
    
    protected function prefix($arg, $anchor) {
        if (URLs::getInstance()->isRaw()) {
            $prefix = Config::getInstance()->app_root;
        } else if ($anchor && URLs::getInstance()->isRoot()) {
            $prefix = '#';
        } else if ($anchor) {
            $prefix = Config::getInstance()->app_root . '#';
        } else {
            $prefix = substr($arg, 0, 1) == '#' && !URLs::getInstance()->isRoot() ? Config::getInstance()->app_root : '';
        }
        return $prefix;
    }
}
