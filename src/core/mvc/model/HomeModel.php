<?php

class HomeModel extends AbstractModel
{
    private $markdown; 
    
    public function __construct()
    {
        $this->entity = 'home';
        $this->markdown = new Markdown();
    }
    
    public function markdown()
    {
        return $this->markdown;
    }
    
    public function getDefaultView()
    {
        return new HomeView($this);
    }
}

?>