<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides the abstract central part of the application and is responsible for loading 
 * and parsing the files.
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
abstract class AbstractModel implements IModel
{

    public $path;

    public $count = 0;

    protected $mime;

    public function __construct($path, $mime)
    {
        $this->path = $path;
        $this->mime = strtolower($mime);
    }

    /**
     * TODO maybe use template method pattern
     *
     * This function loads all respectively specified files contained in the
     * folder
     * stored in $this->path, parses them into a HTML string and returns it.
     *
     * @param unknown $start
     *            - offset where to start, if given
     * @param unknown $limit
     *            - maximum number of files to parse, if given
     * @param array $filter
     *            - array of filter criteria
     */
    public function getList($start = 0, $limit = null, array $filter = array(), $reverse = true)
    {
        $list = array();
        $files = ScanDir::getFilesOfType($this->path, $this->mime);
        $this->filter($files, $filter);
        $this->count = count($files);
        if($reverse)
        {
            rsort($files);
        }
        $limit = is_null($limit) ? count($files) : $limit;
        for ($i = $start; $i < count($files) && $i - $start < $limit; $i ++) {
            $file = $this->path . $files[$i];
            $list[$file] = $this->parse($file);
        }
        return $list;
    }

    /**
     * This function loads the file specified in $this->path, parses it into
     * a HTML string and returns it.
     */
    public function get()
    {
        return $this->parse($this->path);
    }

    /**
     * This function reads the tags from the file, if they have been provided
     *
     * @param unknown $file
     *            - file to parse
     */
    public function parseTags($file)
    {
        try {
            if ($fh = fopen($file, 'r')) {
                
                $tags = array();
                $meta = false;
                
                while (! feof($fh)) {
                    $line = fgets($fh);
                    
                    // opening tag
                    if (! $meta && preg_match('/^(\<\!\-\-).*/', $line)) {
                        $tags['meta'] = array();
                        $meta = true;
                    }
                    // closing tag
                    if ($meta && preg_match('/.*(\-\-\>)|(\-\-\!\>)$/', $line)) {
                        $meta = false;
                    }
                    // search for meta tags
                    if ($meta) {
                        // author
                        if (preg_match('/^\s*(author)\s*(=).*/i', $line)) {
                            $tags['author'] = trim(substr($line, strpos($line, '=') + 1));
                        }
                        // published
                        if (preg_match('/^\s*(published)\s*(=).*/i', $line)) {
                            $tags['published'] = trim(substr($line, strpos($line, '=') + 1));
                        }
                        // categories
                        if (preg_match('/^\s*(categories)\s*(=).*/i', $line)) {
                            $tags['category'] = explode(';', trim(substr($line, strpos($line, '=') + 1)));
                        }
                        // meta
                        if (preg_match('/^\s*(meta)\s*(=).*/i', $line)) {
                            $e = explode('=>', trim(substr($line, strpos($line, '=') + 1)), 2);
                            $tags['meta'][trim($e[0])] = trim($e[1]);
                        }
                    } else {
                        break;
                    }
                }
                fclose($fh);
                return $tags;
            } else {
                throw new Exception('Can not open ' . $file);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(
                new Error('An unexpected error has occurred.', 'AbstractModel::parseTags()', $e->getMessage()));
            return array();
        }
    }

    /**
     * This function filters according to the given criteria.
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

