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
class OnePager extends AbstractPage {

    public function __construct(AbstractModel $model, $config) {
        parent::__construct($model, $config);
    }

    /**
     * This method is used to decide whether to surround the given HTML snippet by a section tag or not.
     * Doing it this way prevents from implementing the check within every visitor method.
     *
     * @param AbstractModel $model that is currently visited
     * @param boolean $bool specifies whether to add the section tag or not
     * @param string $content HTML to surround
     * @return string extended HTML string
     */
    protected function section(AbstractModel $model, $bool, $content) {
        return $bool ? '<section id="' . $model->config['key'] . '"><div class="onepager-item"><div class="container">' . $content . '</div></div></section>' : $content;
    }

    /**
     * @param AbstractModel $model
     * @param null $arg unused
     * @param boolean $bool indicates whether to use section tag or not
     * @return mixed
     */
    public function visit(AbstractModel $model, $arg, $bool) {
        if (array_key_exists('style', $model->config)) {
            Head::getInstance()->link($model->config['style']);
        }
        return $model->accept($this, $arg, $bool);
    }

    public function container(Container $model, $arg, $bool) {
        $string = '';
        foreach ($model->getModels() as $m) {
            $string .= $this->visit($m, $arg, $bool);
        }
        return $string;
    }

    public function composite(Composite $model, $arg, $bool) {
        $string = '';
        foreach ($model->getModels() as $m) {
            $string .= $this->visit($m, $arg, false);
        }
        return $this->section($model, $bool, $string);
    }

    public function collection(Collection $model, $arg, $bool) {
        return $this->section($model, $bool, parent::container($model, $model->start, false) . $this->pager($model));
    }

    public function markup(Markup $model, $arg, $bool) {
        return $this->section($model, $bool, parent::markup($model, $arg, false));
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg, $bool) {
        return $this->section($model, $bool, parent::hypertextPreprocessor($model, $arg, false));
    }

    public function link(Link $model, $arg, $bool) {
        return $this->section($model, $bool, parent::link($model, $arg, false));
    }

    /**
     * This function outputs the HTML string generated during building the view.
     *
     * @return string HTML output
     */
    public function show() {
        return $this->logger() . $this->visit($this->model, null, true);
    }
}
