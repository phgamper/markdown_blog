<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides general config for the projects' backend including sourcecode locations
 * and so on.
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
date_default_timezone_set('Europe/Zurich');

/**
 * Path to the sourcecode directory.
 * Attention: Make sure that this directory is well secured to prevent potential attacks on your webserver.
 *
 * @global SRC_DIR string path of the classroot directory
 */
define('SRC_DIR', '../src/', TRUE);

/**
 * Path to the external libraries used by the MarkdownBlog project.
 *
 * @global LIB_DIR string path of the library directory
 */
define('LIB_DIR', '../src/lib/', TRUE);

/**
 * Path to the configuration directory of the MarkdownBlog project.
 *
 * @global CONFIG_DIR string path of the config directory
 */
define('CONFIG_DIR', '../config/', TRUE);

/**
 * Path to the configuration directory of the MarkdownBlog project.
 *
 * @global CONFIG_DIR string path of the config directory
 */
define('PLUGIN_DIR', CONFIG_DIR.'plugins/', TRUE);

/**
 * Path to the CSS files of the project.
 *
 * @global CSS_DIR string path of the css directory
 */
define('CSS_DIR', 'css/', TRUE);

/**
 * Path to the public library directory of the project.
 *
 * @global PUBLIC_LIB_DIR string path to the directory
 */
define('PUBLIC_LIB_DIR', 'lib/', TRUE);

/**
 * Path for the log files of the project.
 *
 * @global LOG_DIR string path of the log directory
 */
define('LOG_DIR', '../log/', TRUE);

/**
 * The default log file of the project.
 *
 * @global DEFAULT_LOG_FILE string name of the default logfile
 *        
 */

define('DEFAULT_LOG_FILE', 'markdown_blog.log', TRUE);

/**
 * Path to the installed HTML templates
 *
 * @global TEMPLATES_DIR string path of the templates directory
 *
 */
define('TEMPLATES_DIR', 'content/templates/');

?>
