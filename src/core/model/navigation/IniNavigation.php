<?php

/**
 * This file is part of the MarkdownBlog project.
 * It sets up the navigation based on the navigation structure provided by the
 * config file.
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

class IniNavigation extends AbstractNavigation
{

    public function __construct($ini)
    {
        $this->items = $this->init($ini);
    }

    public function getView()
    {
        return new IniNavigationView($this);
    }

    protected function init($ini)
    {
        $items = array();
        $ini = parse_ini_file($ini, true);
        
        foreach ($ini as $key => $value)
        {
            $items[$key] = array();
            $items[$key]['dropdown'] = array();
            
            foreach ($value as $k => $v)
            {
                if (!is_numeric($k) && $k == "name")
                {
                    $items[$key][$k] = $v;
                }
                else if (!is_numeric($k) && $k == "path")
                {
                    $items[$key][$k] = $v;
                }
                else
                {
                    $items[$key][$key][$k] = $v;
                }
            }
        }
        
        return $items;
    }
}

?>
