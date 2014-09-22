<?php

class IniNavigationView implements View
{

    public function __construct(IniNavigation $model)
    {
        $this->model = $model;
    }

    public function show()
    {
        $menu = '';
        
        foreach ($this->model->getItems() as $key => $value)
        {
            $a_class = '';
            $li_class = $_GET['module'] == $key && !isset($_GET['value']) ? 'active' : '';
            $caret = '';
            $submenu = '';

			if(!empty($value['dropdown']))
			{
				foreach ($value['dropdown']['names'] as $i => $subValue)
				{
					$a_class = 'dropdown-toggle" data-toggle="dropdown';
					$caret = '<b class="caret"></b>';
					$href = $_SERVER['PHP_SELF'] . '?module='.$key.'&value='. $i;
					$submenu .= '<li><a href="' . $href . '">' . $subValue . '</a></li>';
				}
                $li_class .= 'dropdown';
                $submenu = '<ul class="dropdown-menu" role="menu">' . $submenu . '</ul>';
           	} 
            $href = $_SERVER['PHP_SELF'] . '?module=' . $key;
            $li = '<a href="' . $href . '" class="' . $a_class . '">' . $value['name'] . $caret . '</a>';
            $menu .= '<li class="' . $li_class . '">' . $li . $submenu . '</li>';
        }

        $string = '<ul class="nav navbar-nav">'.$menu.'</ul>';
        $string = '<div class="navbar-collapse collapse">'.$string.'</div>';
        
        return  $this->container($string);
    }
    
    protected function container($string)
    {
         $container = '<div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="'.$_SERVER['PHP_SELF'].'">Blog.md</a>
        </div>';
        
        $container = '<div class="container-fluid">'.$container.$string.'</div>';
        $container = '<div class="navbar navbar-default navbar-fixed-top" role="navigation">'.$container.'</div>';
        return $container;
    }
}

?>
