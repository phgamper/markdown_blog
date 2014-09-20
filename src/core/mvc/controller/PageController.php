<?php

class PageController extends AbstractController
{
    protected $entity;

    public function __construct()
    {
        parent::__construct();
        $site = $this->entity . 'Model';
        $this->model = new $site();
        self::actionListener();
    }

    public function display()
    {
        return $this->view->show();
    }

    protected function actionListener()
    {
        $tpl = isset($_GET['tpl']) && !$default ? $_GET['tpl'] : '';
           
        switch ($tpl)
        {
            default:
            {
                $this->view = $this->model->getDefaultView();
                break;
            }
        }
        
        Logger::getInstance()->writeLog();
    }
}

?>