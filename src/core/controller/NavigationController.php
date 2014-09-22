<?php

class NavigationController extends AbstractController
{
    protected $template;

    public function __construct(AbstractNavigation $model, $tpl = NAVIGATION_TYPE)
    {
        parent::__construct();
        $this->model = $model;
        $this->view = $model->getView();
        $this->template = $tpl;
    }

    protected function actionListener()
    {
    }
}

?>