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

    public function __construct()
    {
        $ini = IniParser::parseMerged(array(
            SRC_DIR . 'defaults.ini',
            CONFIG_DIR . 'general.ini'
        ));
        $this->config = isset($ini['footer']) ? $ini['footer'] : array();
        Head::getInstance()->link(CSS_DIR . 'footer.css');
    }

    public function show()
    {
        // sitemap
        $sitemap = new NavigationController(new Sitemap(CONFIG_DIR . 'config.ini'));
        // legal notice
        $left = '';
        if (isset($this->config['legal_notice'])) {
            $left = $this->config['legal_notice'];
        }
        $left = '<div class="col-md-6 col-md-offset-2">' . $left . '</div>';
        $right = '<div class="col-md-2"><p class="pull-right"><a href="#">Back to top</a></p></div>';
        // powered by
        $poweredby = '';
        if (isset($this->config['poweredby'])) {
            $poweredby = '<p class="poweredby">' . $this->config['poweredby'] . '</p>';
            $poweredby = '<div class="row"><div class="col-md-8 col-md-offset-2">' . $poweredby . '</div></div>';
        }
        // put it together
        return '<footer>' . $sitemap->display() . '<div class="footer-inner row">' . $left . $right . '</div>' .
             $poweredby . '</footer>';
    }
}

?>
