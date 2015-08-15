<?php

/**
 * This file is part of the MarkdownBlog project.
 * This view shows a page only containing a single formated markdown file hosted
 * on a remote server.
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
class RemoteMarkdownView extends AbstractView
{

    public function __construct(IModel $model, $config)
    {
        parent::__construct($model, $config);
    }

    public function content()
    {
        $panel = '';
        if (isset($this->config['link'])) {
            $panel = '<a href="' . $this->config['link'] . '">' . $this->config['link'] . '</a>';
            $panel = '<div class="panel panel-default"><div class="panel-body">' . $panel . '</div></div>';
            $panel = '<div class="row"><div class="col-md-12">' . $panel . '</div></div>';
        }
        return $panel . '<div class="row markdown"><div class="col-md-12 single">' . $this->model->get() . '</div></div>';
    }
}

?>
