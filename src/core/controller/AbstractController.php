<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the interface for a controller.
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
abstract class AbstractController
{

    protected $entity;

    protected $model;

    protected $view;

    protected $cache = null;

    public function __construct()
    {
        if (! isset($_GET['module'])) {
            $_GET['module'] = 'home';
        }
        
        $this->entity = strtolower($_GET['module']);
    }

    public function cache()
    {
        $this->cache = $this->view->show();
    }

    public function display()
    {
        if(!$this->cache){
            $this->cache = $this->view->show();
        }
        Logger::getInstance()->writeLog();
        return $this->cache;
    }

    /**
     * This method specifies how to react on user input.
     */
    protected abstract function actionListener();
}

?>