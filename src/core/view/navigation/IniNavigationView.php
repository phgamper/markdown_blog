<?php

/**
 * This file is part of the MarkdownBlog project.
 * It generates the navigation based on its model.  
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

class IniNavigationView implements View
{
    private $config;

    public function __construct(IniNavigation $model)
    {
        $this->model = $model;
        $ini = parse_ini_file(CONFIG_DIR . 'general.ini', true);
        
        if (isset($ini['general']))
        {
            $this->config = $ini['general'];
        }
    }

    public function show()
    {
        $menu = '';
        
        foreach ($this->model->getItems() as $key => $value)
        {
            $a_class = '';
            $li_class = $_GET['module'] == $key && !isset($_GET['value']) ? 'active' : '';
            $caret = '';
            $submenu = '';
            
            if (!empty($value['dropdown']))
            {
                foreach ($value['dropdown']['names'] as $i => $subValue)
                {
                    $a_class = 'dropdown-toggle" data-toggle="dropdown';
                    $caret = '<b class="caret"></b>';
                    $href = $_SERVER['PHP_SELF'] . '?module=' . $key . '&value=' . $i;
                    $submenu .= '<li><a href="' . $href . '">' . $subValue . '</a></li>';
                }
                $li_class .= 'dropdown';
                $submenu = '<ul class="dropdown-menu" role="menu">' . $submenu . '</ul>';
            }
            $href = $_SERVER['PHP_SELF'] . '?module=' . $key;
            $li = '<a href="' . $href . '" class="' . $a_class . '">' . $value['name'] . $caret . '</a>';
            $menu .= '<li class="' . $li_class . '">' . $li . $submenu . '</li>';
        }
        
        $string = '<ul class="nav navbar-nav">' . $menu . '</ul>';
        $string = '<div class="navbar-collapse collapse">' . $string . '</div>';
        
        return $this->container($string);
    }

    protected function container($string)
    {
        $container = '';
        
        if (isset($this->config['page_name']))
        {
            $btn = ' <span class="sr-only">Toggle navigation</span>';
            $btn .= '<span class="icon-bar"></span>';
            $btn .= '<span class="icon-bar"></span>';
            $btn .= '<span class="icon-bar"></span>';
            $btn = '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">' .
                 $btn . '</button>';
            $btn .= '<a class="navbar-brand" href="' . $_SERVER['PHP_SELF'] . '">' . $this->config['page_name'] . '</a>';
            $btn = '<div class="navbar-header">' . $btn . '</div>';
            
            $container .= $btn;
        }
        $container = '<div class="container-fluid">' . $container . $string . '</div>';
        $container = '<div class="navbar navbar-default navbar-fixed-top" role="navigation">' . $container . '</div>';
        return $container;
    }
}

?>