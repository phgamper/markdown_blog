<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides a view that displays formatted markdown/html files as a list.
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
class NavigationView extends AbstractView
{
    /**
     *
     * @param Container $model
     * @param array $config
     */
    public function __construct(Container $model, array $config){
        $this->model = $model;
        $this->config = $config;
    }

    /**
     *
     * @return string HTML to show
     */
    public function show(){
        $nav = '';
        foreach($this->model->getModels() as $key => $value){
            $nav .= $this->visit($value, $key);
        }
        return $nav;
    }

    public function image(Image $model, $arg)
    {
        return self::li($model, $arg);
    }

    public function carousel(OwlCarousel $model, $arg){
        return self::li($model, $arg);
    }

    /**
     *
     * @param Collection|Container $model
     * @param int $arg
     * @return string
     */
    public function container(Container $model, $arg){
        $dropdown = '';
        foreach($model->getModels() as $key => $value){
            $dropdown .= $this->visit($value, $arg.'/'.$key);
        }
        $dropdown = '<ul class="dropdown-menu" role="menu">'.$dropdown.'</ul>';
        return '<li class=""><a href="" class="dropdown-toggle" data-toggle="dropdown">'.$model->config['name'].'<b class="caret"></b></a>'.$dropdown.'</li>';
    }

    public function composite(Composite $model, $arg){
        return self::li($model, $arg);
    }

    public function collection(Collection $model, $arg){
        return self::li($model, $arg);
    }

    public function markup(Markup $model, $arg){
        return self::li($model, $arg);
    }

    public function markdown(Markdown $model, $arg)
    {
        return self::markup($model, $arg);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg)
    {
        return self::markup($model, $arg);
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg)
    {
        return self::li($model, $arg);
    }

    public function remote(Remote $model, $arg)
    {
        return self::markdown($model, $arg);
    }

    public function link(Link $model, $arg)
    {
        return '<li><a href="'.$model->config['path'].'">'.$model->config['name'].'</a></li>';
    }

    private function li(AbstractModel $model, $arg){
        $href = Config::getInstance()->getGeneral('general', 'app_root').$arg;
        return '<li><a href="'.$href.'">'.$model->config['name'].'</a></li>';
    }
}

?>
