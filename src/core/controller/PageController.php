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
abstract class PageController extends AbstractController
{
    public function __construct()
    {
        $this->actionListener();
        $this->output = $this->view->show();
        // TODO prepend msg thrown by Logger
        Logger::getInstance()->writeLog();
    }
    
    protected function raw($view){
        if(Config::getInstance()->getGeneral('general', 'raw')){
            $raw = URLs::getInstance()->getURI();
            if (URLs::getInstance()->isRaw() && is_file($raw)) {
                switch(pathinfo($raw, PATHINFO_EXTENSION)){
                    case 'html':
                        $config = array('key' => 'raw', 'name' => 'raw', 'path' => $raw);
                        $model = new HyperTextMarkup($config);
                        break;
                    default:
                        throw new Exception('The requested URL is not available.');
                }
                $this->view = new $view($model, $config);
                return true;
            }
        }
        return false;

    }
}
