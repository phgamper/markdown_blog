<?php

class Footer implements View
{
    protected $config;

    public function __construct()
    {
        $this->config = parse_ini_file(CONFIG_DIR . 'footer.ini', true);
        Head::getInstance()->link(CSS_DIR . 'footer.css');
    }

    public function show()
    {
        // sitemap
        $sitemap = new NavigationController(new Sitemap(CONFIG_DIR . 'navigation.ini'));
        $left = '<p>&copy; blog.md 2014 - created by phgamper - phgamper (at) gmail.com</p>';
        // impressum
        $right = '<p class="pull-right"><a href="#">Back to top</a></p>';
        // put it together
        $footer = '<hr>' . $sitemap->display();
        $footer .= '<footer class="footer">' . $left . $right . '</footer>';
        return $footer;
    }
}

?>