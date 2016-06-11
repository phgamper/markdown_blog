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
class OnePager extends View {
    
    public function __construct(AbstractModel $model, $config){
        parent::__construct($model, $config);
        Script::getInstance()->link(JS_DIR . "onepager.js");
    }

    protected function section(AbstractModel $model, $content) {
        return '<section id="' . $model->config['key'] . '"><div class="onepager-item"><div class="container">' . $content . '</div></div></section>';
    }

    public function visit(AbstractModel $model, $arg) {
        if (array_key_exists('style', $model->config)) {
            Head::getInstance()->link($model->config['style']);
        }
        return $model->accept($this, $arg);
    }
    
    public function container(Container $model, $arg){
        $string = '';
        foreach($model->getModels() as $m) {
            $string .= $this->visit($m,$arg);
        }
        return $string;
    }

    public function collection(Collection $model, $arg) {
        return $this->section($model, parent::container($model, $arg));
    }

    public function markup(Markup $model, $arg) {
        return $this->section($model, parent::markup($model, $arg));
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg) {
        return $this->section($model, parent::hypertextPreprocessor($model, $arg));
    }

    public function link(Link $model, $arg) {
        return "";
    }
    
}
