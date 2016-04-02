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
        Head::getInstance()->link(CSS_DIR . 'content.css');
        if (isset($this->config['style'])) {
            Head::getInstance()->link($this->config['style']);
        }
        if (!($model instanceof Container)) {
            Head::getInstance()->addOg('title', Config::getInstance()->title . ' - ' . $this->config['name']);
            Head::getInstance()->setTitle(Config::getInstance()->title . ' - ' . $this->config['name']);
        }
        if (array_key_exists('description', $this->config)) {
            Head::getInstance()->addOg('description', $this->config['description']);
        }
    }

    /**
     * TODO
     *
     * @param AbstractModel $model to visit
     * @param int $arg
     * @return mixed
     */
    public function visit(AbstractModel $model, $arg) {
        return $model->accept($this, $arg);
    }

    /**
     * TODO not the most general implementation => NavigationView
     *
     * @return string HTML to show
     */
    public function show() {
        //$string = '<div class="row"><div class="col-md-12">' . $this->visit($this->model, null) . '</div></div>';
        $string = $this->visit($this->model, null);
        // append logger output on top
        if (!(isset($this->config['logger']) && !$this->config['logger'])) {
            $string = '<div class="container">' . Logger::getInstance()->toString() . '</div>' . $string;
        }
        return $string;
    }
}
