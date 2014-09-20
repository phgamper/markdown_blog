<?php

class AboutModel extends AbstractModel
{
    public function __construct()
    {
        $this->entity = 'about';
    }
    
    public function getDefaultView()
    {
        return new AboutView($this);
    }
}

?>