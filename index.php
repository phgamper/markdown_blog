<?php

/* 
 * This file is part of the MarkdownBlog project.
 * It is the entry page for the project and is responsible for the proper loading
 * of all needed libraries.
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

include_once ('src/config.php');
include_once (LIB_DIR.'Autoload.php');
include_once (LIB_DIR.'ScanDir.php');
ini_set('display_errors', 1);
$src = Autoload::getInstance(SRC_DIR, false)->getClasses();
$lib = Autoload::getInstance(LIB_DIR, false)->getClasses();
$classes = array_merge($src, $lib);

if (isset($_POST['post']))
{
  $include = $_POST['post'];
  unset($_POST['post']);
  include ($include);
}

new Main();

function __autoload($class)
{
  global $classes;
  include_once ($classes[$class]);
}
?>
