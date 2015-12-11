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
    protected $view;
    protected $output;

    public function __construct()
    {
        $this->actionListener();
        $this->output = $this->view->show();
        // TODO prepend msg thrown by Logger
        Logger::getInstance()->writeLog();
    }

    public function display()
    {
        return $this->output;
    }

    /**
     * This method specifies how to react on user input.
     */
    protected abstract function actionListener();

    /**
     *
     *
     * @param array $config
     * @return Composite
     * @throws ErrorException
     * @throws Exception
     */
    protected function evaluateModel($config){
        if (isset($config['type'])) {
            $type = $config['type'];
        } else {
            throw new ErrorException('There is an error in the configuration file!');
        }

        switch (true) {
            case !array_key_exists('path', $config):
            case $type =='Container':
            case $type =='Composite':
                // type should be Composite or Container
                $model = new $type($config);
                foreach($config as $key => $value){
                    if(is_array($value)){
                        $model->addModel(self::evaluateModel($value), $key);
                    }
                }
                break;
            case is_file($config['path']) || $type == 'OwlCarousel':
            case $type =='Remote':
            case $type == 'Link':
                $model = new $type($config);
                break;
            case is_dir($config['path']):
                $filter = new Filter(new Collection($type, $config));
                $model = $filter->filter();
                break;
            default:
                throw new Exception('The requested URL is not available.');
        }
        return $model;
    }
}

?>