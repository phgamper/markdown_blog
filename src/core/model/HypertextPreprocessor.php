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
class HypertextPreprocessor extends AbstractModel
{
    const MIME = '.php';

    /**
     *
     *
     * @param IVisitor $visitor
     * @param $arg
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg)
    {
        return $visitor->hypertextPreprocessor($this, $arg);
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
                ob_start();
                include $this->config['path'];
                $content = ob_get_contents();
                ob_end_clean();
                return $content;
            } else {
                throw new Exception('File not found: ' . $this->config['path']);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'HypertextPreprocessor::parse("'.$this->config['path'].'")', $e->getMessage()));
            return '';
        }
    }
}

?>
