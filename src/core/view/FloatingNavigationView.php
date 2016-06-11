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

    private $active = "active";

    public function show() {
        $nav = '';
        foreach ($this->model->getModels() as $key => $value) {
            $nav .= $this->visit($value, $key);
        }
        return $nav;
    }

    public function container(Container $model, $arg) {
        return self::li($model, $arg);
    }

    public function link(Link $model, $arg) {
        $raw = URLs::getInstance()->isRaw() && $model->config['path'][0] == '#' ? Config::getInstance()->app_root : '';
        return '<li ' . self::isActive() . '><a class="scroll" href="' . $raw . $model->config['path'] . '">' . $model->config['name'] . '</a></li>';
    }

    protected function li(AbstractModel $model, $arg) {
        $raw = URLs::getInstance()->isRaw() ? Config::getInstance()->app_root : '';
        return '<li ' . self::isActive() . '><a class="scroll" href="' . $raw . '#' . $arg . '">' . $model->config['name'] . '</a></li>';
    }

    private function isActive() {
        $a = URLs::getInstance()->isRaw() ? '' : 'class="' . $this->active . '"';
        $this->active = '';
        return $a;
    }
}
