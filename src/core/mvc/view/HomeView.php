<?php

class HomeView extends AbstractPageView
{

    public function __construct(IModel $model)
    {
        parent::__construct($model, CONFIG_DIR . 'home.ini');
    }

    public function content()
    {
        $string = '';
        $pager = '';
        $limit = null;
        $start = null;

        if (isset($this->config['limit']))
        {
            $limit = $this->config['limit'];
            $start = isset($_GET['page']) && $_GET['page'] > 0 ? $limit * ($_GET['page'] - 1) : 0;
        }
        
        foreach ($this->model->markdown()->getList(MD_DIR, $start, $limit) as $md)
        {
            $string .= '<div class="row markdown"><div class="col-md-12">' . $md . '</div></div>';
        }

        if (isset($this->config['limit']))
        {
            $self = $_SERVER['PHP_SELF'] . '?module=home&page=';
            $prev = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
            $next = isset($_GET['page']) ? $_GET['page'] + 1 : 2;
            if ($prev > 0)
            {
                $pager = '<li class="previous"><a href="' . $self . $prev . '">&larr; Newer</a></li>';
            }
            if ($next <= ceil($this->model->markdown()->count / $limit))
            {
                $pager .= '<li class="next"><a href="' . $self . $next . '">Older &rarr;</a></li>';
            }
            $pager = '<ul class="pager">' . $pager . '</ul>';
            $pager = '<div class="row"><div class="col-md-12">' . $pager . '</div></div>';
        }
        
        
        return $string . $pager;
    }
}

?>