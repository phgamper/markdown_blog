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
    protected $parser;
    
    public function __construct($file)
    {
        $this->parser = new IniParser();
        $this->parser->use_array_object = false;
        $this->init($file);
    }

    public function getView()
    {
        return new IniNavigationView($this);
    }

    protected function init($file)
    {
        $this->items = array();
        $ini = $this->parser->parse($file);
        foreach ($ini as $key => $value)
        {
            $this->items[$key] = array();
            $this->items[$key]['dropdown'] = array();
            
            foreach ($value as $k => $v)
            {
                if (is_array($v))
                {
                    $this->items[$key]['dropdown'][$k] = $v; 
                }
                else
                {
                    $this->items[$key][$k] = $v;
                }
            }
        }
        
        return $this->items;
    }
}

?>
