<?php

class SitemapView implements View
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

			if(!empty($value['dropdown']))	
			{
				foreach ($value['dropdown']['names'] as $i => $subValue)
				{
					$href = $_SERVER['PHP_SELF'] . '?module=' . $key . '&value=' . $i;
					$submenu .= '<li><a href="' . $href . '">' . $subValue . '</a></li>';
				}
                $submenu = '<ul>' . $submenu . '</ul>';
            }
            $href = $_SERVER['PHP_SELF'] . '?module=' . $key;
            $li = '<a href="' . $href . '" class=""><p>' . $value['name'] . '</p></a>';
            $menu .= '<li class="sitemap-top-level"><div class="sitemap-sub-level">' . $li . $submenu . '</div></li>';
        }
        
        $menu = '<div class="row"><ul>'.$menu.'</ul></div>';
        $menu = '<div class="row sitemap"><div class="col-md-12">'.$menu.'</div></div>';
        return $menu;
    }
}

?>
