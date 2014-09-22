<?php

class MarkdownView extends AbstractMarkdownView
{

    public function __construct(Markdown $model, $config)
    {
        parent::__construct($model, $config);
    }

    public function content()
    {
        return '<div class="row markdown"><div class="col-md-12">' . $this->model->get() . '</div></div>';
    }
}

?>
