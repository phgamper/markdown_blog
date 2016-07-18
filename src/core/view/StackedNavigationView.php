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
class StackedNavigationView extends AbstractNavigationView {

    /**
     * StackedNavigationView constructor.
     *
     * @param Container $model
     */
    public function __construct(Container $model) {
        parent::__construct($model, false);
    }

    /**
     * @param Container $model
     * @param int $arg
     * @param $bool
     * @return string
     */
    public function container(Container $model, $arg, $bool) {
        $active = $this->active($arg);
        $dropdown = '';
        foreach ($model->getModels() as $key => $value) {
            $dropdown .= $this->visit($value, $arg . '/' . $key, $bool);
        }
        $dropdown = '<ul class="dropdown-menu" role="menu">' . $dropdown . '</ul>';
        return '<li ' . $active . '><a href="' . $arg . '" class="dropdown-toggle" data-toggle="dropdown">' . $model->config['name'] . '<b class="caret"></b></a>' . $dropdown . '</li>';
    }

    /**
     * @param AbstractModel $model
     * @param string $arg
     * @param bool $anchor
     *
     * @return string
     */
    protected function li(AbstractModel $model, $arg, $anchor) {
        return '<li ' . $this->active($arg) . '><a href="' . Config::getInstance()->app_root . $arg . '">' . $model->config['name'] . '</a></li>';
    }

    /**
     * @param string $arg current path
     * @return string whether the current li is active or not
     */
    protected function active($arg) {
        $active = true;
        $level = count(explode('/', URLs::getInstance()->root())) - 2;
        $regexp = '/' . str_replace('/', '\/', $this->config['root']) . '/';
        foreach (explode('/', preg_replace($regexp, '', $arg, 1)) as $module) {
            $active &= URLs::getInstance()->module($level) == $module;
            $level++;
        }
        return $active ? 'class="active"' : '';
    }
}
