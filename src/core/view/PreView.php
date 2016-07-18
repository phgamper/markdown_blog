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
class PreView extends View {

    public function __construct(AbstractModel $model, array $config) {
        parent::__construct($model, $config);

        Head::getInstance()->link(CSS_DIR . 'preview.css');
    }

    public function collection(Collection $model, $arg, $bool) {
        $heading = '<h3>' . $model->config['name'] . '</h3>';
        $heading = '<div class="row"><div class="col-md-12 text-center">' . $heading . '</div></div>';
        return $heading . parent::collection($model, $arg, $bool);
    }

    public function markup(Markup $model, $arg, $bool) {
        // parse head
        $head = '';
        $tags = $model->parseTags();
        if (!empty($tags)) {
            $head = '';
            if (isset($tags['published'])) {
                $head .= $tags['published'];
            }
            if (isset($tags['author'])) {
                $head = $head ? $head . ' | ' . $tags['author'] : $tags['author'];
            }
            $head = $head ? '<div class="row content-head"><div class="col-md-12"><p>' . $head . '</p></div></div>' : '';
        }
        // parse body
        $body = '<div class="preview"><div class="text">' . $model->parse($arg) . '</div></div>';
        $body = '<div class="row content-item"><div class="col-md-12">' . $body . '</div></div>';

        if (array_key_exists('static', $model->config) && $model->config['static']) {
            $href = Config::getInstance()->app_root . $model->config['static'] . '/' . preg_replace('/\\.[^.\\s]{2,4}$/', '', basename($model->config['path']));
            // social
            $social = '';
            $general = Config::getInstance()->getGeneralArray('general');
            // TODO description
            if (array_key_exists('social', $general) && $general['social']) {
                $buttons = Social::getInstance()->socialButtons('https://' . $_SERVER['HTTP_HOST'] . $href, Head::getInstance()->getTitle());
                $span = floor(6 / count($buttons));
                foreach ($buttons as $b) {
                    $social .= '<div class="col-xs-2 col-md-' . $span . ' text-center">' . $b . '</div>';
                }
            }
            $static = '<a class="btn" href="' . $href . '">More <i class="fa fa-angle-double-right"></i></a>';
            $body .= '<div class="row socials"><div class="col-md-5"><div class="row">' . $social . '</div></div><div class="col-md-7 text-right">' . $static . '</div></div>';
        }
        return $head . $body;
    }

    public function markdown(Markdown $model, $arg, $bool) {
        return self::markup($model, $arg, $bool);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg, $bool) {
        return parent::markup($model, $arg, $bool);
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg, $bool) {
        $heading = '<h3>' . $model->config['name'] . '</h3>';
        $heading = '<div class="row"><div class="col-md-12 text-center">' . $heading . '</div></div>';
        return $heading . parent::hypertextPreprocessor($model, $arg, $bool);
    }
}
