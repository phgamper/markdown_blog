<?php

abstract class AbstractPageView extends View
{
    protected $config;

    public function __construct(IModel $model, $inifile)
    {
        parent::__construct($model);
        if (file_exists($inifile))
        {
            $this->config = parse_ini_file($inifile, true);
        }
    }

    public function show()
    {
        $string = '<div class="row"><div class="col-md-12">' . $this->content() . '</div></div>';
        $string .= $this->footer();
        // append logger output on top
        if (isset($this->config['logger']) && $this->config['logger'])
        {
            $string = Logger::getInstance()->toString() . $string;
        }
        
        return $this->container($string);
    }

    protected abstract function content();

    protected function footer()
    {
        $footer = '';
        
        if (isset($this->config['footer']) && $this->config['footer'])
        {
            $f = new Footer();
            $footer = $f->show();
        }
        
        return $footer;
    }

    protected function back($span = 12, $offset = 0, $row = true)
    {
        $back = $_SERVER['PHP_SELF'] . '?module=' . $_GET['module'];
        $back = '<div class="col-md-' . $span . ' col-md-offset-' . $offset . '"><a href="' . $back .
             '">zur&uuml;ck</a></div>';
        $back = $row ? '<div class="row">' . $back . '</div>' : $back;
        return $back;
    }

    protected function container($string)
    {
        return '<div class="container">' . $string . '</div>';
        ;
    }
}

?>