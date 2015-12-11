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
class Carousel implements IVisitor
{
    private $model;

    public function __construct(AbstractModel $model){
        $this->model = $model;
    }

    public function items(){
        return self::visit($this->model, null);
    }

    public function visit(AbstractModel $model, $arg){
        return $model->accept($this, $arg);
    }

    public function container(Container $model, $arg){
        return array(); // TODO not implemented || unused
    }

    public function composite(Composite $model, $arg){
        $items = array();
        foreach($model->models as $m){
            $items = array_merge($items, self::visit($m, $arg));
        }
        return $items;
    }

    public function collection(Collection $model, $arg){
        $items = array();
        for($i = 0; $i < $model->count && $i < $model->limit; $i++){
            $items[] = self::visit($model->models[$i], $model->start);
        }
        return $items;
    }

    public function image(Image $model, $arg){
        return array(); // TODO not implemented || unused
    }

    public function carousel(OwlCarousel $model, $arg){
        return array(); // TODO not implemented || unused
    }

    public function markup(Markup $model, $arg){
        $tags = $model->parseTags();
        $item = array();
        if (array_key_exists('name', $tags)) {
            $item['name'] = $tags['name'];
            $item['static'] = Config::getInstance()->app_root.$model->config['static'].'/'.preg_replace('/\\.[^.\\s]{2,4}$/', '', basename($model->config['path']));
        }
        return $item;
    }

    public function markdown(Markdown $model, $arg){
        return self::markup($model, $arg);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg){
        return self::markup($model, $arg);
    }

    // public function remote(Remote $model, $arg);
    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg)
    {
        return array(); // TODO not implemented || unused
    }

    public function remote(Remote $model, $arg)
    {
        return self::markup($model, $arg);
    }

    public function link(Link $model, $arg)
    {
        return array(); // TODO not implemented || unused
    }
}
