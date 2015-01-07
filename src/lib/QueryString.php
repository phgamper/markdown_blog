<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides functions to modify $_SERVER['QUERY_STRING']  
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
class QueryString
{

    public static function remove($search, $query)
    {
        // improve performance
        if (isset($_GET[$search])) {
            $e = explode('&', $query);
            $query = '';
            foreach ($e as $v) {
                if (trim(substr($v, 0, strpos($v, '='))) != $search) {
                    $query .= '&' . $v;
                }
            }
            // remove the first &
            $query = substr($query, 1);
        }
        return $query;
    }

    public static function removeAll(array $search, $query)
    {
        foreach ($search as $s) {
            $query = self::remove($s, $query);
        }
        return $query;
    }
}

?>
