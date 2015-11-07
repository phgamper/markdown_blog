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
        $this->output = $this->view->show();
        // TODO prepend msg thrown by Logger
        Logger::getInstance()->writeLog();
    }

    /**
     *
     */
    protected function actionListener()
    {
        try {
            // load the configuration file
            if (isset($this->config[$this->module])) {
                $config = $this->config[$this->module];
            } else {
                throw new Exception('The requested URL is not available.');
            }
            $config = $this->resolveURL($config, 1);
            $this->model = $this->evaluateModel($config);
            $view = array_key_exists('view', $config) && $config['view'] ? $config['view'] : 'View';
            $this->view = new $view($this->model, $config);
        } catch (ErrorException $e) {
            $config = Config::getInstance()->getErrorArray('500');
            $log = new Error('An unexpected error has occurred.', 'Controller::actionListener()', $e->getMessage());
            self::exception($log, $config, 500);
        } catch (Exception $e) {
            $config = Config::getInstance()->getErrorArray('404');
            $log = new Warning($e->getMessage(), 'Controller::actionListener()');
            self::exception($log, $config, 404);
        }
    }

    /**
     * @param Logable $log
     * @param $config
     * @param $code
     */
    protected function exception(Logable $log, $config, $code){
        http_response_code($code);
        Logger::getInstance()->add($log);

        try {
            $this->model = $this->evaluateModel($config);
            $view = array_key_exists('view', $config) && $config['view'] ? $config['view'] : 'View';
            $this->view = new $view($this->model, $config);
        } catch (ErrorException $e) {
            die();
        } catch (Exception $e) {
            $config = Config::getInstance()->getErrorArray('404');
            $log = new Error('There is a misconfiguration in the error behaviour.', 'Controller::exception()', $e->getMessage());
            self::exception($log, $config, 404);
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

    protected function resolveURL($config, $level){
        if ($value = URLs::getInstance()->level($level)) {
            // if a dropdown is present
            if (array_key_exists($value, $config)) {
                $config = self::resolveURL($config[$value], $level + 1);
            }else{
                $config['path'] = $config['path'].$value.$config['type']::MIME;
            }
        }
        return $config;
    }
}
