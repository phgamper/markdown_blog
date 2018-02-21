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
abstract class AbstractNavigationView extends AbstractView {

    protected $anchor;

    /**
     *
     * @param Container $model
     * @param boolean $anchor indicates whether to use anchors (true) or urls (false)
     */
    public function __construct(Container $model, $anchor) {
        $this->model = $model;
        $this->anchor = $anchor;
    }

    /**
     *
     * @return string HTML to show
     */
    public function show() {
        $nav = '';
        foreach ($this->model->getModels() as $key => $value) {
            $nav .= $this->visit($value, $key, $this->anchor);
        }
        return $nav;
    }

    public function composite(Composite $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function collection(Collection $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function markup(Markup $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function markdown(Markdown $model, $arg, $bool) {
        return $this->markup($model, $arg, $bool);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg, $bool) {
        return $this->markup($model, $arg, $bool);
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function remote(Remote $model, $arg, $bool) {
        return $this->markdown($model, $arg, $bool);
    }

    /**
     * @param Link $model
     * @param $arg
     * @param $bool
     * @return mixed|string
     */
    public abstract function link(Link $model, $arg, $bool);

    public function image(Image $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function photoSwipe(PhotoSwipe $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    public function csv(CSV $model, $arg, $bool) {
        return $this->li($model, $arg, $bool);
    }

    /**
     * @param AbstractModel $model
     * @param mixed $arg
     * @param boolean $anchor indicates whether the link is an anchor (true) or url (false)
     * @return mixed
     */
    protected abstract function li(AbstractModel $model, $arg, $anchor);

    /**
     * @param string $arg current path
     * @return string whether the current li is active or not
     */
    protected abstract function active($arg);

    protected function prefix($anchor) {
        $root = URLs::getInstance()->root();
        if ($anchor && URLs::getInstance()->isRoot()) {
            $prefix = '#';
        } else if ($anchor) {
            $prefix = "$root#";
        } else {
            $prefix = $root;
        }
        return $prefix;
    }
}
