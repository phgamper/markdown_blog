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
 *
 *
 * Enter description here ...
 * 
 * @global string SRC_DIR path of the classroot directory
 */
define('SRC_DIR', 'src/', TRUE);

/**
 *
 *
 * Enter description here ...
 * 
 * @global string LIB_DIR path of the library directory
 */
define('LIB_DIR', 'src/lib/', TRUE);

/**
 *
 *
 * Enter description here ...
 * 
 * @global string CSS_DIR path of the config directory
 */
define('CONFIG_DIR', 'config/', TRUE);


/**
 * 
 * Enter description here ...
 * 
 * @global string LOG_DIR path of the log directory
 */
define('LOG_DIR', 'log/', TRUE);

/**
 * 
 * Enter description here ...
 * 
 * @global string CSS_DIR path of the log directory
 */
define('CSS_DIR', 'public/css/', TRUE);


/**
 *
 * Enter description here ...
 *
 * @global path to error.md
 */
define('ERROR_MD', 'src/error.md', TRUE);


/**
 * 
 * * Enter description here ...
 * 
 * @global string DEFAULT_LOG_FILE name of the default logfile
 * 
 */
define('DEFAULT_LOG_FILE', 'default.log', TRUE);


?>
