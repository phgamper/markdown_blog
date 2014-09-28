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
        $this->mime = $mime;
        Head::getInstance()->link(CSS_DIR . 'markdown.css');
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
     */
    public function getList($start = 0, $limit = null)
    {
        $list = array();
        $files = ScanDir::getFilesOfType($this->path, $this->mime);
        $this->count = count($files);
        rsort($files);
        $limit = is_null($limit) ? count($files) : $limit;
        
        for ($i = $start; $i < count($files) && $i - $start < $limit; $i ++)
        {
            $list[] = $this->parse($this->path . $files[$i]);
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
     */
    protected function parseTags($fh)
    {
        $tags = array();
        $meta = false;
        
        while (!feof($fh))
        {
            $line = fgets($fh);
            
            // opening tag
            if (!$meta && preg_match('/^(\<\!\-\-).*/', $line))
            {
                $meta = true;
            }
            // closing tag
            if ($meta && preg_match('/.*(\-\-\>)|(\-\-\!\>)$/', $line))
            {
                $meta = false;
            }
            // search for meta tags
            if ($meta)
            {
                // author
                if (preg_match('/^\s*(author)\s*(=).*/i', $line))
                {
                    $tags['author'] = trim(substr($line, strpos($line, '=') + 1));
                }
                // published
                if (preg_match('/^\s*(published)\s*(=).*/i', $line))
                {
                    $tags['published'] = trim(substr($line, strpos($line, '=') + 1));
                }
                // categories
                if (preg_match('/^\s*(categories)\s*(=).*/i', $line))
                {
                    $tags['categories'] = explode(';', trim(substr($line, strpos($line, '=') + 1)));
                }
            }
            else
            {
                break;
            }
        }
        return $tags;
    }

    /**
     * This function builds the head containing the meta information 
     * 
     * @param unknown $tags
     * @return string
     */
    protected function head($tags)
    {
        $head = '';
        
        if (!empty($tags))
        {
            $author = isset($tags['author']) ? $tags['author'] : '';
            $published = isset($tags['published']) ? $tags['published'] : '';
            $left = '<p>' . $published . ' | ' . $author . '</p>';
            $left = '<div class="col-md-4">' . $left . '</div>';
            $right = '';
            if (isset($tags['categories']))
            {
                $href = '#'; // TODO serach for categories
                             // $_SERVER['PHP_SELF'].$_S
                foreach ($tags['categories'] as $c)
                {
                    // $right .= ' | <a
                    // href="'.$href.'&tag='.$c.'">#'.trim($c).'</a>';
                    $right .= ' | #' . trim($c);
                }
                $right = '<div class="col-md-8 pull-right text-right">' . substr($right, 3) . '</div>';
            }
            $head = '<div class="row">' . $left . $right . '</div>';
        }
        return $head;
    }
}

?>

