<?php

class SitemapView extends AbstractNavigationView
{

    public function __construct(IniNavigation $model)
    {
        $this->model = $model;
        Head::getInstance()->link(CSS_DIR.'sitemap.css');
    }

    public function show()
    {
        $menu = '';
        
        foreach ($this->model->getItems() as $key => $value)
        {
            $submenu = '';
            
            foreach ($value[$key] as $subKey => $subValue)
            {
                if (is_numeric($subKey))
                {
                    $href = $_SERVER['PHP_SELF'] . '?module=' . $key . '&value=' . $subValue;
                }
                else
                {
                    $href = $_SERVER['PHP_SELF'] . '?module=' . $subKey;
                }
                $submenu .= '<li><a href="' . $href . '">' . $subValue . '</a></li>';
            }
            
            if ($submenu != '')
            {
                $submenu = '<ul>' . $submenu . '</ul>';
            }
            
            $href = $_SERVER['PHP_SELF'] . '?module=' . $key;
            $li = '<a href="' . $href . '" class=""><p>' . $value['name'] . '</p></a>';
            $menu .= '<li class="sitemap-top-level"><div class="sitemap-sub-level">' . $li . $submenu . '</div></li>';
        }
        
        $menu = '<div class="row"><ul>'.$menu.'</ul></div>';
        $menu = '<div class="row sitemap"><div class="span12">'.$menu.'</div></div>';
        return $menu;
    }
}

?>