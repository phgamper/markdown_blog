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
abstract class AbstractController {

    protected $view;
    protected $output;

    public function __construct() {
        $this->actionListener();
    }

    public function display() {
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
     * @param $key
     * @return Composite
     * @throws ErrorException
     * @throws Exception
     */
    protected function evaluateModel($config, $key) {
        $config['key'] = $key;
        if (array_key_exists('type', $config)) {
            $type = $config['type'];
        } else {
            throw new ErrorException('There is an error in the configuration file!');
        }

        switch (true) {
            case !array_key_exists('path', $config):
            case $type == 'Container':
            case $type == 'Composite':
                // type should be Composite or Container
                $model = new $type($config);
                self::addModel($model, $config);
                break;
            case is_dir($config['path']) && $type != 'PhotoSwipe' && $type != 'Link':
                $filter = new Filter(new Collection($type, $config));
                $model = $filter->filter();
                break;
            case $type == 'Markdown':
            case $type == 'HyperTextMarkup':
            case $type == 'HypertextPreprocessor':
            case $type == 'Image':
            case $type == 'Remote':
            case $type == 'Link':
            case $type == 'PhotoSwipe':
                $model = new $type($config);
                break;
            default:
                throw new Exception('The requested URL is not available.');
        }
        return $model;
    }

    /**
     * @param Logable $log
     * @param $config
     * @param $code
     */
    protected function exception(Logable $log, $config, $code) {
        http_response_code($code);
        Logger::getInstance()->add($log);

        try {
            $model = $this->evaluateModel($config, 'exeption');
            $view = array_key_exists('view', $config) && $config['view'] ? $config['view'] : 'View';
            $this->view = new $view($model, $config);
        } catch (ErrorException $e) {
            die();
        } catch (Exception $e) {
            $config = Config::getInstance()->getErrorArray('404');
            $log = new Error('There is a misconfiguration in the error behaviour.', 'Controller::exception()', $e->getMessage());
            self::exception($log, $config, 404);
        }
    }

    protected function addModel(Container $model, $config) {
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $model->addModel($this->evaluateModel($value, $key), $key);
            }
        }
    }
}
