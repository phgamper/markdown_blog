<?php

class AboutView extends AbstractPageView
{
    public function __construct(IModel $model)
    {
        parent::__construct($model, CONFIG_DIR.'about.ini');
    }
    
    public function content()
    {
        return "<h1>About Blog.md</h1>";
    }
}

?>