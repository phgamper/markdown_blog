<?php

class Sitemap extends IniNavigation
{

    public function __construct($ini)
    {
        parent::__construct($ini);
    }

    public function getView()
    {
        return new SitemapView($this);
    }
}

?>
