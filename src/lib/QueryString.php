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

    public static function remove($search)
    {
        $query = $_SERVER['QUERY_STRING'];
        
        if (isset($_GET[$search]))
        {
            $query = str_replace('&' . $search . '=' . $_GET[$search], '', $query);
            $query = str_replace($search . '=' . $_GET[$search], '', $query);
            $query = substr($query, -1) == '&' ? $query = substr($query, 0, -1) : $query;
        }
        return $query;
    }

    public static function removeAll(array $search)
    {
        $query = $_SERVER['QUERY_STRING'];
        
        foreach ($search as $value)
        {
            if (isset($_GET[$value]))
            {
                $query = str_replace('&' . $value . '=' . $_GET[$value], '', $query);
                $query = str_replace($value . '=' . $_GET[$value], '', $query);
                $query = substr($query, -1) == '&' ? $query = substr($query, 0, -1) : $query;
            }
        }
        return $query;
    }
}

?>