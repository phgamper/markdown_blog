<?php

class MarkdownController extends AbstractController
{
    protected $entity;
    protected $config;

    public function __construct()
    {
        parent::__construct();
        
        $inifile = CONFIG_DIR.'navigation.ini';
        
        if (file_exists($inifile))
        {
            $this->config = parse_ini_file($inifile, true);
        }

        self::actionListener();
    }

    protected function actionListener()
    {
        $ini = CONFIG_DIR.$this->entity.'.ini';
        
        switch (true)
        {
            case isset($this->config[$this->entity]['path']) && is_dir($this->config[$this->entity]['path']):
            {
                $this->model = new Markdown($this->config[$this->entity]['path']);
                $this->view = new MarkdownListView($this->model, $ini);
                break;
            }
            case isset($this->config[$this->entity]['path']) && is_file($this->config[$this->entity]['path']):
            {
                $this->model = new Markdown($this->config[$this->entity]['path']);
                $this->view = new MarkdownView($this->model, $ini);
                break;
            }
            default:
            {
                $this->model = new Markdown('md/home/');
                $this->view = new MarkdownListView($this->model, $ini);
            }
        }
        
        Logger::getInstance()->writeLog();
    }
}

?>