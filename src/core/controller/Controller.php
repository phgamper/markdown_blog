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
class Controller extends AbstractController
{
    protected $module;

    protected $config;

    public function __construct()
    {
        $this->module = URLs::getInstance()->module();
        $this->config = Config::getInstance()->config;
        $this->actionListener();
        $this->cache();
    }

    /**
     *
     */
    protected function actionListener()
    {
        // TODO refactor
        try {
            // load the configuration file
            if (isset($this->config[$this->module])) {
                $config = $this->config[$this->module];
            } else {
                throw new Exception('The requested URL is not available.');
            }
            // try to resolve URL
            if ($value = URLs::getInstance()->level(1)) {
                // if a dropdown is present
                if (array_key_exists($value, $config)) {
                    $config = $config[$value];
                    $value = false;
                    // TODO Hack to support blog in dropdown
                    $value = URLs::getInstance()->level(2);
                }
            }
            $this->model = $this->evaluateModel($config);
            $this->view = new View($this->model, $config);
        } catch (ErrorException $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'Controller::actionListener()', $e->getMessage()));
            $this->model = new Markdown(ERROR_MD);
            $this->view = new View($this->model, array('name' => 'Error', 'logger' => true));
        } catch (Exception $e) {
            Logger::getInstance()->add(new Warning($e->getMessage(), 'Controller::actionListener()'));
            $this->model = new Markdown(ERROR_MD);
            $this->view = new View($this->model, array( 'logger' => true ));
        }
    }

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
                // type should be Composite
                $model = new Composite($config);
                foreach($config as $item){
                    if(is_array($item)){
                        $model->addModel(self::evaluateModel($item));
                    }
                }
                break;
            case is_file($config['path']) || $type == 'Carousel':
                $model = new $type($config);
                break;
            case is_dir($config['path']):
                $filter = new Filter(new Collection($type, $config));
                $model = $filter->filter();
                break;
            default:
                // should never happen
                throw new Exception('The requested URL is not available.');
        }
        return $model;
    }
}
?>
