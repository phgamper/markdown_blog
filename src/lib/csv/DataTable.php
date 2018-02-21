<?php

/**
 * This file is part of the MarkdownBlog project.
 * TODO ...
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
class DataTable extends SimpleTable {

    public function __construct($file, $conf)
    {
        parent::__construct($file, $conf);
        Head::getInstance()->link(PUBLIC_LIB_DIR."dataTables/css/dataTables.bootstrap.min.css");
        Script::getInstance()->link(PUBLIC_LIB_DIR."dataTables/js/jquery.dataTables.min.js");
        Script::getInstance()->link(PUBLIC_LIB_DIR."dataTables/js/dataTables.bootstrap.min.js");
    }

    protected function table($head, $body, $hash) {
        Script::getInstance()->inline("$(document).ready(function(){ $('#".$hash."').dataTable( { \"iDisplayLength\": 100 } ); });");
        return '<div class="table-responsive"><table id="'.$hash.'" class="table table-hover table-bordered">'.$head.$body.'</table></div>';
    }
}