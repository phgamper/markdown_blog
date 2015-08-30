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
class ListView extends AbstractView
{

    public function __construct(IModel $model, $config)
    {
        parent::__construct($model, $config);
    }

    public function content()
    {
        $string = '';
        $pager = '';
        $limit = null;
        $start = 0;
        
        // enabling filtering if hashtag is given
        $filter = isset($_GET['tag']) ? array(
            'category' => $_GET['tag']
        ) : array();
        // detect number of columns to show
        $cols = isset($this->config['columns']) && $this->config['columns'] > 0 ? $this->config['columns'] : 1;
        $width = floor(12 / $cols);
        if (isset($this->config['limit'])) {
            $limit = $this->config['limit'] * $cols;
            $start = isset($_GET['page']) && $_GET['page'] > 0 ? $limit * ($_GET['page'] - 1) : 0;
        }
        $reverse = isset($this->config['reverse']) ? $this->config['reverse'] : true;
        $it = new ArrayIterator($this->model->getList($start, $limit, $filter, $reverse));
        $item_left = $it->count();
        while ($it->valid()) {
            $column = '';
            $i = 0;
            $break = ceil($item_left / $cols);
            while ($it->valid() && $i < $break) {
                $head = $this->head($this->model->parseTags($it->current()['path']));
                $body = '<div class="row"><div class="col-md-12 content-body">' . $it->current()['html'] . '</div></div>';
                if (!$this->model instanceof Image && (!array_key_exists('static', $this->config) || $this->config['static'])){
                    $href = Config::getInstance()->app_root.URLs::getInstance()->getURI().'/'.$it->current()['link'];
                    // social
                    $social = '';
                    $general = Config::getInstance()->getGeneralArray('general');
                    // TODO description
                    if (array_key_exists('social', $general) && $general['social']) {
                        $social = Social::getInstance()->socialButtons('https://'.$_SERVER['HTTP_HOST'].$href, Head::getInstance()->getTitle());
                    }
                    // TODO refactor, instance of Markdown, ...
                    $static = '<a class="btn btn-default" href="'.$href.'" role="button">Static <i class="fa fa-share-alt"></i></a>';
                    $body .= '<div class="row"><div class="col-md-4"><div class="row">'.$social.'</div></div><div class="col-md-8 text-right">'.$static.'</div></div>';
                }
                $column .= '<div class="row"><div class="col-md-12 list-item">' . $head . $body . '</div></div>';
                $it->next();
                $i ++;
            }
            $cols--;
            $item_left -= $break;
            $string .= '<div class="col-md-' . $width . ' list-column">' . $column . '</div>';
        }
        $string = '<div class="row list">' . $string . '</div>';
        
        if (!is_null($limit)) {
            $prev = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
            $next = isset($_GET['page']) ? $_GET['page'] + 1 : 2;
            $self = URLs::getInstance()->getURI() . '?' . QueryString::remove('page', $_SERVER['QUERY_STRING']) . '&page=';
            $self = Config::getInstance()->app_root.$self;
            if ($prev > 0) {
                $pager = '<li class="previous"><a href="' . $self . $prev . '">&larr; Newer</a></li>';
            }
            if ($next <= ceil($this->model->count / ($limit))) {
                $pager .= '<li class="next"><a href="' . $self . $next . '">Older &rarr;</a></li>';
            }
            $pager = '<ul class="pager">' . $pager . '</ul>';
            $pager = '<div class="row"><div class="col-md-12">' . $pager . '</div></div>';
        }

        if ($this->model instanceof Image){
            $carousel = $this->model->carousel($reverse);
            $carousel = '<div class="modal-dialog"><div class="modal-content">'.$carousel.'</div></div>';
            $carousel = '<div class="modal fade" id="carousel-modal" role="dialog">'.$carousel.'</div>';
            $string .= $carousel;
        }


        return $string . $pager;
    }
}

?>
