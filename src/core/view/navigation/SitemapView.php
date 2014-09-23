<?php

/**
 * This file is part of the MarkdownBlog project.
 * It generates the view of the sitemap based on its model.
 *
 * MarkdownBlog is a lightweight blog software written in php and twitter bootstrap.
 * Its purpose is to provide a easy way to share your thoughts without any Database
 * or special setup needed.
 *
 * Copyright (C) 2014 Philipp Gamper & Max Schrimpf
 *
 * The project is free software: You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The file is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with the project. if not, write to the Free Software Foundation, Inc.
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */


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
