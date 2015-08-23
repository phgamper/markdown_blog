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
abstract class AbstractView implements IView
{

    protected $config;

    public function __construct(IModel $model, $config)
    {
        $this->model = $model;
        $this->config = $config;
        Head::getInstance()->link(CSS_DIR . 'content.css');
        if (isset($this->config['style']))
        {
            Head::getInstance()->link($this->config['style']);
        }
        Head::getInstance()->addOg('title', Config::getInstance()->title.' - '.$this->config['name']);
        Head::getInstance()->setTitle(Config::getInstance()->title.' - '.$this->config['name']);
        if (array_key_exists('description', $this->config)){
            Head::getInstance()->addOg('description', $this->config['description']);
        }
    }

    public function show()
    {
        $string = '<div class="row"><div class="col-md-12">' . $this->content() . '</div></div>';
        // append logger output on top
        if (! (isset($this->config['logger']) && ! $this->config['logger'])) {
            $string = Logger::getInstance()->toString() . $string;
        }
        return $string;
    }

    protected abstract function content();

    /**
     * This function builds the head containing the meta information
     *
     * TODO move HTML to View, just provide a function to get the tags
     *
     * @param unknown $tags            
     * @return string
     */
    protected function head($tags)
    {
        $head = '';
        
        if (! empty($tags)) {
            $left = '';
            if (isset($tags['published'])) {
                $left .= $tags['published'];
            }
            if (isset($tags['author'])) {
                $left = $left ? $left . ' | ' . $tags['author'] : $tags['author'];
            }
            $left = $left ? '<div class="col-md-5"><p>' . $left . '</p></div>' : '';
            $right = '';
            if (isset($tags['category'])) {
                $href = Config::getInstance()->app_root.URLs::getInstance()->getURI() . '?' . QueryString::removeAll(array('tag', 'page'), $_SERVER['QUERY_STRING']);
                foreach ($tags['category'] as $c) {
                    $right .= ' | <a href="' . $href . '&tag=' . $c . '">#' . trim($c) . '</a>';
                    // $right .= ' | #' . trim($c);
                }
                $right = '<div class="col-md-7 pull-right text-right">' . substr($right, 3) . '</div>';
            }
            $head = $left . $right ? '<div class="row content-head">' . $left . $right . '</div>' : '';
            // adding meta tags
            if (isset($tags['meta'])) {
                foreach ($tags['meta'] as $name => $content) {
                    Head::getInstance()->addMeta($name, $content);
                }
            }
        }
        return $head;
    }
}

?>
