<?php

/**
 * This file is part of the MarkdownBlog project.
 * It is the interface for all possible markdown/html file orders.
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
abstract class AbstractView implements IView, IVisitor {

    protected $config;
    protected $model;

    /**
     * TODO maybe at the wrong place
     *
     * @param AbstractModel $model to view
     * @param array $config
     */
    public function __construct(AbstractModel $model, array $config) {
        $this->model = $model;
        $this->config = $config;
    }

    /**
     * TODO
     *
     * @param AbstractModel $model to visit
     * @param int $arg
     * @param boolean $bool
     * @return mixed
     */
    public function visit(AbstractModel $model, $arg, $bool) {
        return $model->accept($this, $arg, $bool);
    }

    /**
     * This function outputs the HTML string generated during building the view.
     *
     * @return string HTML output
     */
    public function show() {
        $out = $this->visit($this->model, null, false);
        return $this->logger() . $out;
    }

    /**
     *
     * @return string parsed logger output
     */
    protected function logger() {
        if (!(isset($this->config['logger']) && !$this->config['logger'])) {
            return Logger::getInstance()->toString();
        }
        return '';
    }
}
