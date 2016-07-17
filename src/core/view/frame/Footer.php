<?php

/**
 * This file is part of the MarkdownBlog project.
 * It generates the footer of every page based on the config file.
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
class Footer implements IView
{
    protected $config;
    protected $controller; // TODO hmm ... not nice

    public function __construct(NavigationController $controller)
    {
        $this->controller = $controller;
        $this->config = Config::getInstance()->getGeneralArray('footer');
        Head::getInstance()->link(CSS_DIR.'footer.css');
    }

    public function show()
    {
        // sitemap
        $sitemap = $this->controller->sitemap();
        // legal notice
        $left = array_key_exists('legal_notice', $this->config) ? $this->config['legal_notice'] : '';
        $left = '<div class="col-md-8"><p>' . $left . '</p></div>';
        $right = '<div class="col-md-4"><p class="pull-right"><a href="#">Back to top</a></p></div>';
        // social
        $social = '';
        $general = Config::getInstance()->getGeneralArray('general');
        if (array_key_exists('social', $general) && $general['social']) {
            $buttons = Social::getInstance()->socialButtons('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], Head::getInstance()->getTitle());
            $span = floor(6/count($buttons));
            foreach($buttons as $b){
                $social .= '<div class="col-xs-2 col-md-'.$span.' text-center">'.$b.'</div>';
            }
            $x = floor((8 - count($buttons)) / 2);
            $social = '<div class="row"><div class="col-md-offset-2 col-md-'.$x.'"></div>'.$social.'</div>';
        }
        // powered by
        $poweredby = '';
        if (isset($this->config['poweredby'])) {
            $poweredby = '<p class="poweredby text-center">' . $this->config['poweredby'] . '</p>';
            $poweredby = '<div class="row"><div class="col-md-8 col-md-offset-2">' . $poweredby . '</div></div>';
        }
        // put it together
        return $sitemap .'<div class="footer-inner row">'. $left . $right .'</div>'.$social.$poweredby;
    }
}
