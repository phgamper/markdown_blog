<?php

class MarkdownController extends AbstractController
{
    protected $entity;
    protected $config;

    public function __construct()
    {
        parent::__construct();
        
        $inifile = CONFIG_DIR.'config.ini';
        
        if (file_exists($inifile))
        {
            $this->config = parse_ini_file($inifile, true);
        }

        self::actionListener();
    }

    protected function actionListener()
    {
		$config = $this->config[$this->entity];

		if(isset($_GET['value']) && isset($config['paths'])) 
		{
			if(array_key_exists($v = $_GET['value'], $config['paths']))
			{
				$path = $config['paths'][$v];
			}
			else
			{
				$path = 'error.md';
			}
		}
		else if(isset($config['path']))
		{
			$path = $config['path'];
		}
		else
		{
			$path = 'error.md';
		}
        
        switch (true)
        {
            case is_dir($path):
            {
                $this->model = new Markdown($path);
                $this->view = new MarkdownListView($this->model, $config);
                break;
            }
            case is_file($path):
            {
                $this->model = new Markdown($path);
                $this->view = new MarkdownView($this->model, $config);
                break;
            }
            default:
            {
                $this->model = new Markdown('README.md');
                $this->view = new MarkdownListView($this->model, $config);
            }
        }
        
        Logger::getInstance()->writeLog();
    }
}

?>
