<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the central part of the application and is responsible for loading 
 * and parsing the markdown files.
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
class MarkdownRemote extends AbstractModel
{

    public $path;

    public $count = 0;

    public function __construct($path)
    {
        parent::__construct($path, '.md');
    }

    /**
     * This function loads the file specified in $this->path, parses it into
     * a HTML string and returns it.
     */
    public function get()
    {
        // TODO check the index
        return $this->parse(0);
    }

    /**
     * TODO maybe use templates method pattern
     *
     * This function loads all respectively specified files contained in the
     * folder
     * stored in $this->path, parses them into a HTML string and returns it.
     *
     * @param int $start offset where to start, if given
     * @param int $limit maximum number of files to parse, if given
     * @param array $filter array of filter criteria
     *
     * @return array list of entities
     */
    public function getList($start = 0, $limit = null, array $filter = array())
    {
        return array();
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param unknown $index - index of parsed element
     * @return parsed Markdown
     * @internal param unknown $file - file to parse
     */
    public function parse($index)
    {
        return Parsedown::instance()->parse($file);
    }
}

?>

