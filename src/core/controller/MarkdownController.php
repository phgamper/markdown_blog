<?php

/**
 * This file is part of the MarkdownBlog project.
 * Interacts with the View and loads the requested parts form the model.
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
class MarkdownController extends AbstractController
{
    protected $entity;
    protected $config;

    public function __construct()
    {
        parent::__construct();
        
        $inifile = CONFIG_DIR . 'config.ini';
        
        if (file_exists($inifile))
        {
            $this->config = parse_ini_file($inifile, true);
        }
        
        self::actionListener();
    }

    protected function actionListener()
    {
        $config = $this->config[$this->entity];
        
        if (isset($_GET['value']) && isset($config['paths']))
        {
            if (array_key_exists($v = $_GET['value'], $config['paths']))
            {
                $path = $config['paths'][$v];
            }
            else
            {
                $path = 'error.md';
            }
        }
        else 
            if (isset($config['path']))
            {
                $path = $config['path'];
            }
            else
            {
                $path = 'error.md';
            }
        
        switch (true)
        {
            case is_dir($path):
            {
                $this->model = new Markdown($path);
                $this->view = new MarkdownListView($this->model, $config);
                break;
            }
            case is_file($path):
            {
                $this->model = new Markdown($path);
                $this->view = new MarkdownView($this->model, $config);
                break;
            }
            default:
            {
                $this->model = new Markdown('README.md');
                $this->view = new MarkdownListView($this->model, $config);
            }
        }
        
        Logger::getInstance()->writeLog();
    }
}

?>
