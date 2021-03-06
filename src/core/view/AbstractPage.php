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
abstract class AbstractPage extends AbstractView {

    public function __construct(AbstractModel $model, array $config) {
        parent::__construct($model, $config);
        Head::getInstance()->link(CSS_DIR . 'style.css');
        if (isset($this->config['style'])) {
            Head::getInstance()->link($this->config['style']);
        }
    }

    public function image(Image $model, $arg, $bool) {
        return $model->parse($arg);
    }

    public function photoSwipe(PhotoSwipe $model, $arg, $bool) {
        return $model->parse($arg);
    }

    /**
     *
     * @param Collection|Container $model
     * @param int $arg
     * @param $bool
     * @return string
     */
    public function container(Container $model, $arg, $bool) {
        $string = '';
        $cols = isset($model->config['columns']) && $model->config['columns'] > 0 ? $model->config['columns'] : 1;
        $width = floor(12 / $cols);
        $break = $arg;
        $it = new ArrayIterator($model->getModels());
        $item_left = $it->count();
        while ($it->valid()) {
            $column = '';
            $break += ceil($item_left / $cols);
            while ($it->valid() && $arg < $break) {
                $column .= '<div class="row"><div class="col-md-12 list-item">' . $this->visit($it->current(), $arg, $bool) . '</div></div>';
                $it->next();
                $item_left--;
                $arg++;
            }
            $cols--;
            $string .= '<div class="col-sm-' . $width . ' list-column">' . $column . '</div>';
        }
        return '<div class="row list">' . $string . '</div>';
    }

    public function composite(Composite $model, $arg, $bool) {
        return $this->container($model, $arg, $bool);
    }

    public function collection(Collection $model, $arg, $bool) {
        return $this->container($model, $model->start, $bool) . $this->pager($model);
    }

    public function markup(Markup $model, $arg, $bool) {
        // parse head
        $head = '';
        $tags = $model->parseTags();
        if (!empty($tags)) {
            $left = '';
            if (isset($tags['published'])) {
                $left .= $tags['published'];
            }
            if (isset($tags['author'])) {
                $left = $left ? $left . ' | ' . $tags['author'] : $tags['author'];
            }
            $left = $left ? '<div class="col-md-7"><p>' . $left . '</p></div>' : '';
            $right = '';
            if (isset($tags['category'])) {
                $href = Config::getInstance()->app_root . URLs::getInstance()->getURI() . '?' . QueryString::removeAll(['tag', 'page'], $_SERVER['QUERY_STRING']);
                foreach ($tags['category'] as $c) {
                    $right .= ' | <a href="' . $href . '&tag=' . $c . '">#' . trim($c) . '</a>';
                    // $right .= ' | #' . trim($c);
                }
                $right = '<div class="col-md-5 pull-right text-right">' . substr($right, 3) . '</div>';
            }
            $head = $left . $right ? '<div class="row content-head">' . $left . $right . '</div>' : '';
        }
        // parse body
        $body = '<div class="row content-body"><div class="col-md-12">' . $model->parse($arg) . '</div></div>';

        if (array_key_exists('static', $model->config) && $model->config['static']) {
            $href = Config::getInstance()->app_root . URLs::getInstance()->getURI() . '/' . preg_replace('/\\.[^.\\s]{2,4}$/', '', basename($model->config['path']));
            // social
            $social = '';
            $general = Config::getInstance()->getGeneralArray('general');
            // TODO description
            if (array_key_exists('social', $general) && $general['social']) {
                $buttons = Social::getInstance()->socialButtons('https://' . $_SERVER['HTTP_HOST'] . $href, Head::getInstance()->getTitle());
                $span = floor(6 / count($buttons));
                foreach ($buttons as $b) {
                    $social .= '<div class="col-xs-2 col-md-' . $span . ' text-center">' . $b . '</div>';
                }
            }
            $static = '<a class="btn btn-default" href="' . $href . '" role="button">Static <i class="fa fa-share-alt"></i></a>';
            $body .= '<div class="row content-foot"><div class="col-md-5"><div class="row">' . $social . '</div></div><div class="col-md-7 text-right">' . $static . '</div></div>';
        }
        return '<div class="row content-item"><div class="col-md-12">' . $head . $body . '</div></div>';
    }

    public function markdown(Markdown $model, $arg, $bool) {
        return $this->markup($model, $arg, $bool);
    }

    public function hyperTextMarkup(HyperTextMarkup $model, $arg, $bool) {
        return $this->markup($model, $arg, $bool);
    }

    public function hypertextPreprocessor(HypertextPreprocessor $model, $arg, $bool) {
        return $model->parse($arg);
    }

    public function remote(Remote $model, $arg, $bool) {
        return $this->markup($model, $arg, $bool);
    }

    public function link(Link $model, $arg, $bool) {
        return '<div class="row content-item"><div class="col-md-12">' . $model->parse($arg) . '</div></div>';
    }

    public function csv(CSV $model, $arg, $bool) {
        $content = '';
        $conf = array_key_exists('conf', $this->config) ? $this->config['conf'] : array();

        if (array_key_exists('title', $conf) && $conf['title']) {
            $title = strtolower(str_replace('/', ' > ', URLs::getInstance()->getURI()));
            $content .= '<div class="row"><div class="col-md-12"><h2>'.$title.'</h2></div></div><hr>';
        }
        if (array_key_exists('readme', $conf) && $conf['readme']) {
            $content .= $this->visit(new Markdown(array('path' => $conf['readme'])), 0, FALSE);
        }
        if (array_key_exists('loadable', $conf) && $conf['loadable']) {
            $content .= '<div class="row" style="padding-bottom: 16px"><div class="col-md-12 text-right"><a class="btn btn-default" href="'.$conf['loadable'].'?csv='.$this->config['path'].'";">Download CSV</a></div></div>';
        }
        if (array_key_exists('filter', $conf) && $conf['filter']) {
            $content .= '<div class="row"><div class="col-md-12"><div class="input-group"> <span class="input-group-addon">Filter</span><input id="filter" type="text" class="form-control" placeholder="Type here..."></div></div></div>';
        }

        return $content.$model->parse($arg);
    }

    protected function pager($model){
        $pager = '';
        if (!array_key_exists('paging', $model->config) || $model->config['paging']) {

            if (!is_null($model->limit)) {
                $prev = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] - 1 : 0;
                $next = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] + 1 : 2;
                $self = URLs::getInstance()->getURI() . '?' . QueryString::remove('page', $_SERVER['QUERY_STRING']) . '&page=';
                $self = Config::getInstance()->app_root . $self;
                if ($prev > 0) {
                    $pager = '<li class="previous"><a href="' . $self . $prev . '"><i class="fa fa-chevron-left"></i> Newer</a></li>';
                }
                if ($next <= ceil($model->count / ($model->limit))) {
                    $pager .= '<li class="next"><a href="' . $self . $next . '">Older <i class="fa fa-chevron-right"></i></a></li>';
                }
                $pager = '<ul class="pager">' . $pager . '</ul>';
                $pager = '<div class="row"><div class="col-md-12">' . $pager . '</div></div>';
            }
        }
        return $pager;
    }
}
