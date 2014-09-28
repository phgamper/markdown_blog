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
class Markdown extends AbstractModel
{
    public $path;
    public $count = 0;

    public function __construct($path)
    {
        parent::__construct($path, '.md');
    }
    
    /**
     * This function parse the given file into HTML and outputs a string
     * containing its content.
     *
     *
     * @param unknown $file
     *            - file to parse
     */
    public function parse($file)
    {
        try
        {
            if ($fh = fopen($file, 'r'))
            {
                $tags = $this->parseTags($fh);
                if (!rewind($fh))
                {
                    throw new Exception('Could not rewind ' . $file);
                }
                $content = $this->head($tags) . Parsedown::instance()->parse(fread($fh, filesize($file)));
                fclose($fh);
                return $content;
            }
            else
            {
                throw new Exception('Can not open ' . $file);
            }
        }
        catch (Exception $e)
        {
            Logger::getInstance()->add(
                new Error('An unexpected error has occurred.', 'Markdown::parse("' . $file . '")'), $e->getMessage());
            return '';
        }
    }
    
    protected function head($tags)
    {
        $head = '';
    
        if(!empty($tags))
        {
            $author = isset($tags['author']) ? $tags['author'] : '';
            $published = isset($tags['published']) ? $tags['published'] : '';
            $left = '<p>'.$published.' | ' .$author. '</p>';
            $left = '<div class="col-md-4">'.$left.'</div>';
            $right = '';
            if(isset($tags['categories']))
            {
                $href = '#'; // TODO serach for categories $_SERVER['PHP_SELF'].$_S
                foreach($tags['categories'] as $c)
                {
                    //$right .= ' | <a href="'.$href.'&tag='.$c.'">#'.trim($c).'</a>';
                    $right .= ' | #'.trim($c);
                }    
                $right = '<div class="col-md-8 pull-right text-right">'.substr($right, 3).'</div>';
            }
            $head = '<div class="row">'.$left.$right.'</div>';
        }
        return $head;
    }
}

?>

