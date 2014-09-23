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

class Footer implements View
{
    protected $config;

    public function __construct()
    {
        $this->config = parse_ini_file(CONFIG_DIR . 'general.ini', true);
        Head::getInstance()->link(CSS_DIR . 'footer.css');
    }

    public function show()
    {
        // sitemap
        $sitemap = new NavigationController(new Sitemap(CONFIG_DIR . 'config.ini'));
        // legal notice
        $left = '';
        if(isset($this->config['legal_notice']))
        {
            $left = $this->config['legal_notice'];
        }
        $left = '<div class="col-md-9">'.$left.'</div>';
        $right = '<div class="col-md-3"><p class="pull-right"><a href="#">Back to top</a></p></div>';
        // license
        $license = '<p class="license">&copy; <a href="https://github.com/phgamper/markdown_blog" title="MarkdownBlog on github">MarkdownBlog</a> 2014 - GPL v3.0</p>';
        // put it together
        $footer = '<hr>' . $sitemap->display();
        $footer .= '<footer class="footer"><div class="row">' . $left . $right . '</div>'.$license.'</footer>';
        return $footer;
    }
}

?>
