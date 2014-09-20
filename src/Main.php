<?php

class Main
{

    public function __construct()
    {
        Head::getInstance()->link('public/bootstrap/css/bootstrap.min.css');
        Head::getInstance()->link(CSS_DIR.'style.css');
        Script::getInstance()->link('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
        Script::getInstance()->link('public/bootstrap/js/bootstrap.js');
        $navigation = new NavigationController(new IniNavigation(CONFIG_DIR.'navigation.ini'));
        $controller = new MarkdownController();
        

        // display all
        $string = '';
        $string = $navigation->display();
        $string .= $controller->display();
        $head = Head::getInstance()->toString();
        $script = Script::getInstance()->toString();
        //include FRAME_ROOT_PATH . 'script.php';
        echo '<!DOCTYPE html><html lang="en">'.$head.'<body>'.$string.$script.'</body></html>';
    }
}

?>