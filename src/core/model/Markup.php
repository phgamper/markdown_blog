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
abstract class Markup extends AbstractModel
{
    /**
     * This function reads the tags from the file, if they have been provided
     *
     * @return array parsed tags
     */
    public function parseTags()
    {
        try {
            if ($fh = fopen($this->config['path'], 'r')) {

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
                        // name
                        if (preg_match('/^\s*(name)\s*(=).*/i', $line)) {
                            $tags['name'] = trim(substr($line, strpos($line, '=') + 1));
                        }
                        // description
                        if (preg_match('/^\s*(description)\s*(=).*/i', $line)) {
                            $tags['description'] = trim(substr($line, strpos($line, '=') + 1));
                        }
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
                throw new Exception('Can not open ' . $this->config['path']);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(new Error('An unexpected error has occurred.', 'Markup::parse("'.$this->config['path'].'")', $e->getMessage()));
            return array();
        }
    }
}

?>

