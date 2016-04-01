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
class SitemapView extends AbstractNavigationView
{
    public function show() {
        return '<div class="row sitemap"><div class="sitemap-inner col-md-offset-2 col-md-8"><div class="row""><ul class = "sitemap-top-level">'.parent::show().'</ul></div></div></div>';
    }

    /**
     *
     * @param Collection|Container $model
     * @param int $arg
     * @return string
     */
    public function container(Container $model, $arg){
        $sitemap = '';
        foreach($model->getModels() as $key => $value){
            $sitemap .= $this->visit($value, $arg.'/'.$key);
        }
        return '<li><p>'.$model->config['name'].'</p><div class="sitemap-sub-level"><ul>'.$sitemap.'</ul></div></li>';
    }

    public function link(Link $model, $arg) {
        return '<li><p><a href="'.$model->config['path'].'">'.$model->config['name'].'</a></p></li>';
    }
    
    protected function li(AbstractModel $model, $arg){
        return '<li><p><a href="'.$arg.'">'.$model->config['name'].'</a></p></li>';
    }
}
