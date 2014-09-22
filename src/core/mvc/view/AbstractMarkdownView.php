<?php

abstract class AbstractMarkdownView implements View
{
    protected $config;

    public function __construct(Markdown $model, $config)
    {
        $this->model = $model;
        $this->config = $config;
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
        return '<div class="container">' . $string . '</div>';
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
}

?>
