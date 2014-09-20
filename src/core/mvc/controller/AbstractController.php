<?php

abstract class AbstractController
{
    protected $entity;
    protected $model;
    protected $view;

    public function __construct()
    {
        if (!isset($_GET['module']))
        {
            $_GET['module'] = 'home';
        }
        
        $this->entity = strtolower($_GET['module']);
    }

    public function display()
    {
        return $this->view->show();
    }

    protected abstract function actionListener();
}

?>