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
abstract class Markup extends AbstractModel implements ILeaf{

    /**
     * This function reads the tags from the file, if they have been provided
     *
     * @return array parsed tags
     */
    public function parseTags() {
        return self::tags($this->config['path']);
    }

    public static function tags($file) {
        try {
            if ($fh = fopen($file, 'r')) {
                $tags = [];
                $meta = false;
                while (!feof($fh)) {
                    $line = fgets($fh);
                    // opening tag
                    if (!$meta && preg_match('/^(\<\!\-\-).*/', $line)) {
                        $tags['meta'] = [];
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
                        // images
                        if (preg_match('/^\s*(images)\s*(=).*/i', $line)) {
                            $tags['images'] = explode(';', trim(substr($line, strpos($line, '=') + 1)));
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
            Logger::getInstance()->add(new Fault('An unexpected error has occurred.', 'Markup::tags("' . $file . '")', $e->getMessage()));
            return [];
        }
    }

    public static function text($file) {
        try {
            if ($fh = fopen($file, 'r')) {
                $out = '';
                if (!feof($fh) && preg_match('/^(\<\!\-\-).*/', $line = fgets($fh))) {
                    while(!feof($fh)) {
                        $line = fgets($fh);
                        if (preg_match('/.*(\-\-\>)|(\-\-\!\>)$/', $line)){
                            break;
                        }
                    }
                } else {
                    $out = $line;
                }
                while (!feof($fh)) {
                    $out .= fgets($fh);
                }
                fclose($fh);
                return $out;
            } else {
                throw new Exception('Can not open ' . $file);
            }
        } catch (Exception $e) {
            Logger::getInstance()->add(new Fault('An unexpected error has occurred.', 'Markup::text("' . $file . '")', $e->getMessage()));
            return '';
        }

    }
}

