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
class Filter implements IVisitor
{
    private $collection;

    public function __construct(Collection $collection){
        $this->collection = $collection;
    }

    public function filter(){
        return self::visit($this->collection(), null);
    }

    public function visit(AbstractModel $model, $arg){
        return $this->collection->accept($this, $arg);
    }

    public function composite(Composite $model, $arg){
        return null; // TODO not implemented || unused
    }

    public function collection(Collection $model, $arg){
        $criteria = isset($_GET['tag']) ? array('category' => $_GET['tag']) : array();
        if(!empty($criteria)){
            foreach ($model->models as $m) {
                if(!self::visit($m, $criteria)){
                    unset($m);
                }
            }
        }
        return $model;
    }

    public function image(Image $model, $arg){
        return null; // TODO not implemented || unused
    }

    public function carousel(Carousel $model, $arg){
        return null; // TODO not implemented || unused
    }

    public function markup(Markup $model, $arg){
        $tags = $model->parseTags();
        foreach ($arg as $key => $value) {
            if (isset($tags[$key])) {
                if (is_array($tags[$key])) {
                    if (in_array($value, $tags[$key])) {
                        continue; // check next criteria
                    }
                } else {
                    if ($tags[$key] == $value) {
                        continue; // check next criteria
                    }
                }
            }
            // at least one criteria does not match
            return false;
        }
        return true;
    }

    public function markdown(Markdown $model, $arg){
        return self::markup($model, $arg);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg){
        return self::markup($model, $arg);
    }

    // public function remote(Remote $model, $arg);
}

?>
