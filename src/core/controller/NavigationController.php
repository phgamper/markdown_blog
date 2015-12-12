<?php

/**
 * This file is part of the MarkdownBlog project.
 * Interacts with the concrete NavigationView and loads the requested parts form the model.
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
class NavigationController extends AbstractController
{
    private $view = "NavigationView";
    private $model;
    private $config;

    public function __construct(){
        parent::__construct();
        Head::getInstance()->link(CSS_DIR.'sitemap.css');
    }

    public function setView($view){
        $this->view = $view;
    }

    public function display(){
        $output = (new $this->view($this->model, $this->config))->show();
        Logger::getInstance()->writeLog();
        return $output;
    }

    protected function actionListener(){
        try{
            $module = URLs::getInstance()->module();
            if (Config::getInstance()->hasPlugin($module)) {
                // if the module part of the URI may be a plugin
                $config = Config::getInstance()->getPlugin($module);
            } else {
                $config = Config::getInstance()->getConfig();
            }
            $this->model = new Container($config);
            foreach($config as $key => $value) {
                $this->model->addModel(parent::evaluateModel($value), $key);
            }
        } catch (ErrorException $e) {
            die(); // TODO
        } catch (Exception $e) {
            die(); // TODO
        }
    }
}

?>