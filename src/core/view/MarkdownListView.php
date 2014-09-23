<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides a view that displays formatted markdown files as a list.
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

class MarkdownListView extends AbstractMarkdownView
{

    public function __construct(Markdown $model, $config)
    {
        parent::__construct($model, $config);
    }

    public function content()
    {
        $string = '';
        $pager = '';
        $limit = null;
        $start = 0;

        if (isset($this->config['limit']))
        {
            $limit = $this->config['limit'];
            $start = isset($_GET['page']) && $_GET['page'] > 0 ? $limit * ($_GET['page'] - 1) : 0;
        }
        
        foreach ($this->model->getList($start, $limit) as $md)
        {
            $string .= '<div class="row markdown"><div class="col-md-12">' . $md . '</div></div>';
        }

        if (isset($this->config['limit']))
        {
            $prev = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
            $next = isset($_GET['page']) ? $_GET['page'] + 1 : 2;
            $self = $_SERVER['PHP_SELF'] . '?'.QueryString::remove('page').'&page=';
            if ($prev > 0)
            {
                $pager = '<li class="previous"><a href="' . $self . $prev . '">&larr; Newer</a></li>';
            }
            if ($next <= ceil($this->model->count / $limit))
            {
                $pager .= '<li class="next"><a href="' . $self . $next . '">Older &rarr;</a></li>';
            }
            $pager = '<ul class="pager">' . $pager . '</ul>';
            $pager = '<div class="row"><div class="col-md-12">' . $pager . '</div></div>';
        }
        
        
        return $string . $pager;
    }
}

?>
