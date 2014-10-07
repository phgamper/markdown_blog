<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides a container for Logables and mark them to be written into the log file.
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
class Log
{

    public $msg;

    public $TSP;

    public $alert;

    public $trigger;

    public function __construct(Logable $l)
    {
        $this->TSP = date('YmdHms');
        $this->msg = $l->getLogMsg();
        $this->trigger = $l->getTrigger();
        $this->alert = $l->getSymbol();
    }

    public function toString()
    {
        return "$this->TSP:\t$this->alert\t$this->trigger\t$this->msg\n";
    }
}

?>