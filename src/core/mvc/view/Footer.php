<?php

class Footer implements View
{
    protected $config;

    public function __construct()
    {
        $this->config = parse_ini_file(CONFIG_DIR . 'general.ini', true);
        Head::getInstance()->link(CSS_DIR . 'footer.css');
    }

    public function show()
    {
        // sitemap
        $sitemap = new NavigationController(new Sitemap(CONFIG_DIR . 'config.ini'));
        // legal notice
        $left = '';
        if(isset($this->config['legal_notice']))
        {
            $left = $this->config['legal_notice'];
        }
        $left = '<div class="col-md-9">'.$left.'</div>';
        $right = '<div class="col-md-3"><p class="pull-right"><a href="#">Back to top</a></p></div>';
        // license
        $license = '<p class="license">&copy; <a href="https://github.com/phgamper/markdown_blog" title="MarkdownBlog on github">MarkdownBlog</a> 2014 - GPL v3.0</p>';
        // put it together
        $footer = '<hr>' . $sitemap->display();
        $footer .= '<footer class="footer"><div class="row">' . $left . $right . '</div>'.$license.'</footer>';
        return $footer;
    }
}

?>