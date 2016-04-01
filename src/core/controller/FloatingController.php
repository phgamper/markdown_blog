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
class FloatingController extends AbstractController {

    public function __construct() {
        $this->actionListener();
        $this->output = $this->view->show();
        // TODO prepend msg thrown by Logger
        Logger::getInstance()->writeLog();
    }

    protected function actionListener() {
        try {
            // load the configuration file
            $module = URLs::getInstance()->module();
            if (Config::getInstance()->hasModule($module)) {
                $config = Config::getInstance()->getConfig();
            } else if (Config::getInstance()->hasPlugin($module)) {
                // if the module part of the URI may be a plugin
                $config = Config::getInstance()->getPlugin($module);
            } else {
                throw new Exception('The requested URL is not available.');
            }
            $model = new Container($config);
            foreach ($config as $key => $value) {
                $model->addModel($this->evaluateModel($value, $key), $key);
            }
            $view = array_key_exists('view', $config) && $config['view'] ? $config['view'] : 'OnePager';
            $this->view = new $view($model, $config);
        } catch (ErrorException $e) {
            $config = Config::getInstance()->getErrorArray('500');
            $log = new Error('An unexpected error has occurred.', 'FloatingController::actionListener()', $e->getMessage());
            self::exception($log, $config, 500);
        } catch (Exception $e) {
            $config = Config::getInstance()->getErrorArray('404');
            $log = new Warning($e->getMessage(), 'FloatingController::actionListener()');
            self::exception($log, $config, 404);
        }
    }

    protected function resolveURL($config, $level) {
        if ($value = URLs::getInstance()->level($level)) {
            // if a dropdown is present
            if (array_key_exists($value, $config)) {
                $config = self::resolveURL($config[$value], $level + 1);
            } else if (array_key_exists('path', $config)) {
                // if URL points to static link
                $config['path'] = $config['path'] . $value . $config['type']::MIME;
            } else {
                throw new Exception('The requested URL is not available.');
            }
        }
        return $config;
    }
}
