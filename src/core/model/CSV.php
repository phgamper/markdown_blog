<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the central part of the application and is responsible for loading 
 * and parsing the PHP files.
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
class CSV extends AbstractModel implements ILeaf
{
    const MIME = '.csv';

    /**
     *
     *
     * @param IVisitor $visitor
     * @param mixed $arg
     * @param boolean $bool
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg, $bool)
    {
        return $visitor->csv($this, $arg, $bool);
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param int $index - index of parsed element
     * @return string parsed HTML
     */
    public function parse($index)
    {
        try {
            if (file_exists($this->config['path'])) {
                $conf = array_key_exists('conf', $this->config) ? $this->config['conf'] : array();
                if (array_key_exists('ajax', $conf)) {
                    $csv = new AjaxTable($this->config['path'], $conf);
                } else if (array_key_exists('data', $conf) && $conf['data']) {
                    $csv = new DataTable($this->config['path'], $conf);
                }else {
                    $csv = new SimpleTable($this->config['path'], $conf);
                }
                return $csv->show();
            } else {
                throw new Exception('File not found: ' . $this->config['path']);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(new Fault("An unexpected error has occurred. '".$e->getMessage()."'", 'CSV::parse("'.$this->config['path'].'")', $e->getMessage()));
            return '';
        }
    }
}
