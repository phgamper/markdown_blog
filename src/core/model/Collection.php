<?php

/**
 * This file is part of the MarkdownBlog project.
 * TODO
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
class Collection extends AbstractModel
{
    public $models = array();

    public $limit = null;

    public $start = 0;

    public $cols = 1;

    // TODO must be Markup
    public function __construct($model, $config, $path, $mime)
    {
        parent::__construct($path, $mime);
        $this->mime = strtolower($mime);
        $start = 0;
        // enabling filtering if hashtag is given
        $filter = isset($_GET['tag']) ? array('category' => $_GET['tag']) : array();
        // detect number of columns to show
        $this->cols = isset($config['columns']) && $config['columns'] > 0 ? $config['columns'] : 1;
        if (isset($config['limit'])) {
            $this->limit = $config['limit'] * $this->cols;
            $start = isset($_GET['page']) && $_GET['page'] > 0 ? $this->limit * ($_GET['page'] - 1) : 0;
        }
        $reverse = isset($config['reverse']) ? $config['reverse'] : true;
        $files = ScanDir::getFilesOfType($this->path, $this->mime);
        $this->filter($files, $filter);
        $this->count = count($files);
        if($reverse)
        {
            rsort($files);
        }
        $this->limit = is_null($this->limit) ? count($files) : $this->limit;
        for ($i = $start; $i < count($files) && $i - $start < $this->limit; $i ++) {
            $this->models[] = new $model($this->path.$files[$i], $i);
        }
    }

    /**
     *
     *
     * @param IVisitor $visitor
     * @param $arg
     * @return mixed
     */
    public function accept(IVisitor $visitor, $arg){
        return $visitor->collection($this, $this->start);
    }

    // merge get and parse?!
    public function get()
    {
        return $this->models;
    }

    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     * @param unknown $file - file to parse
     * @param unknown $index - index of parsed element
     * @return parsed image
     */
    public function parse($file, $index)
    {
        return '';
    }

    /**
     * This function filters according to the given criteria.
     *
     * TODO make work
     *
     * @param array $files
     *            - files being filtered, array passed by reference
     * @param array $criteria
     *            - array of filter criteria
     * @throws Exception
     * @return string
     */
    public function filter(array &$files, array $criteria)
    {
        if (! empty($criteria)) {
            try {
                foreach ($files as $i => $name) {
                    $tags = $this->parseTags($this->path . $name);
                    foreach ($criteria as $key => $value) {
                        if (isset($tags[$key])) {
                            if (is_array($tags[$key])) {
                                if (in_array($value, $tags[$key])) {
                                    continue; // check next criteria
                                }
                            } else {
                                if ($tags[$key] == $value) {
                                    continue; // check next criteria
                                }
                            }
                        }
                        // at least one criteria does not match
                        unset($files[$i]);
                        break;
                    }
                }
            } catch (Exception $e) {
                Logger::getInstance()->add(
                    new Error('Could not filter according the given criteria', 'AbstractModel::filter("' . $file . '")'),
                    $e->getMessage());
            }
        }
    }
}

?>

