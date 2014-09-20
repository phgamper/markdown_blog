<?php

class MarkdownView extends AbstractMarkdownView
{

    public function __construct(Markdown $model, $ini)
    {
        parent::__construct($model, $ini);
    }

    public function content()
    {
        return '<div class="row markdown"><div class="col-md-12">' . $this->model->get() . '</div></div>';
    }
}

?>