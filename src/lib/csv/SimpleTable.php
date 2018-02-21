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
class SimpleTable {

    protected $file;

    protected $conf = array();
    protected $visible = array();
    protected $mobile = array();
    protected $labels = array();

    protected $modals = "";

    public function __construct($file, $conf) {
        Script::getInstance()->link(PUBLIC_LIB_DIR."csv/simple.js");
        $this->file = $file;
        $this->conf = $conf;
        $visible = explode(';', array_key_exists('visible', $conf) ? $conf['visible'] : array());
        $this->visible = array_map("intval", $visible);
        $mobile = explode(';', array_key_exists('mobile', $conf) ? $conf['mobile'] : array());
        $this->mobile = array_map("intval", $mobile);
    }
    
    public function show() {
        $ret = '';
        if(!is_file($this->file)){
            Logger::getInstance()->add(new Fault('No such File: "'.$this->file.'"', 'SimpleTable::show()'));
        } else {
            if (($handle = fopen($this->file, 'r'))) {
                if (($hdr = fgetcsv($handle, 0, ';')) && ($csv = fgetcsv($handle, 0, ';'))) {
                    $hash = hash('crc32', $this->file);
                    $head = $this->head($hdr);
                    $body = $this->body($handle, $csv);
                    $ret = $this->table($head, $body, $hash);
                } else {
                    Logger::getInstance()->add(new Info('Provided File is empty', 'SimpleTable::show()'));
                }
                fclose($handle);
            }
        }
        return $ret.$this->modals;
    }

    protected function table($head, $body, $hash)
    {
        // TODO table-hover => class
        return '<table id="' . $hash . '" class="table table-hover">' . $head . $body . '</table>';
    }

    protected function head(array $line) {
        $ret = '';
        foreach ($line as $i => $item) {
            $this->labels[$i] = $item;
            if (empty($this->visible) || in_array($i, $this->visible)) {
                $hidden = empty($this->mobile) || in_array($i, $this->mobile) ? 'class="hidden-xs"' : '';
                $ret .= "<th $hidden>$item</th>";
            }
        }
        return '<thead><tr>'.$ret.'</tr></thead>';
    }

    protected function body($handle, array $csv) {
        $ret = '';
        do {
            $ret .= '<tr scope="row" >'.$this->row($csv).'</tr>';
        } while (($csv = fgetcsv($handle, 0, ';')));
        return '<tbody class="searchable">' . $ret . '</tbody>';
    }

    protected function row(array $csv) {
        $attr = $this->modal($csv);
        $td = '';
        foreach ($csv as $i => $cell) {
            if (empty($this->visible) || in_array($i, $this->visible)) {
                $hidden = empty($this->mobile) || in_array($i, $this->mobile) ? 'class="hidden-xs"' : '';
                $td .= '<td scope="col" '.$hidden.' '.$attr.'>'.$cell.'</td>';
            }
        }
        return $td;
    }

    protected function modal(array $line) {
        $attr = '';
        if (array_key_exists('modal', $this->conf) && $this->conf['modal']) {
            $id = md5(implode($line));
            $attr = 'style="cursor: pointer; cursor: hand" data-toggle="modal" data-target="#'.$id.'"';
            $modal = '';
            foreach ($line as $i => $item) {
                if (!array_key_exists('action', $this->labels)) {
                    $json = json_decode(str_replace('\'', '"', $item), true);
                    if (!is_null($json) && is_array($json)) {
                        $list = '';
                        foreach ($json as $elem) {
                            $elem = is_array($elem) ? implode(" / ", $elem) : $elem;
                            $list .= "<li>$elem</li>";
                        }
                        $modal .= '<tr><th>'.$this->labels[$i].'</th><td><ul>'.$list.'</ul></td></tr>';
                    } else {
                        $modal .= '<tr><th>'.$this->labels[$i].'</th><td>'.$item.'</td></tr>';
                    }
                }
            }
            $modal = '<div class="table-responsive"><table class="table table-hover">'.$modal.'</table></div>';
            $this->modals .= <<< HTML
    <div class="modal fade" id="$id" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 80%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <strong aria-hidden="true">&times;</strong>
                    </button>
                    <h5 class="modal-title">&nbsp;</h5>
                </div>
                <div class="modal-body">
                    $modal
                </div>
            </div>
        </div>
    </div>
HTML;
        }
        return $attr;
    }
}