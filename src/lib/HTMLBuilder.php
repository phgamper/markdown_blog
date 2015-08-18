<?php

/**
 * This file is part of the MarkdownBlog project.
 * It provides some basic HTML snippet.
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
abstract class HTMLBuilder
{
    public static function carousel(array $images, $name = 'main-carousel', $lazy = true)
    {
        if($lazy){
            Script::getInstance()->link('lib/lazy-carousel/js/lazy-bootstrap-carousel-v3.js');
            Script::getInstance()->link('lib/lazy-carousel/js/base.js');
            Head::getInstance()->link('lib/lazy-carousel/css/base.css');
        }
        $items = '';
        $ind = '';
        $class = 'active';
        for($i = 0; $i < count($images); $i++){
            // Carousel items
            $items .= '<div class="item '.$class.'">';
            if($lazy){
                $items .= '<img lazy-src="'.$images[$i].'" />';
            }else{
                $items .= '<img src="'.$images[$i].'" />';
            }
            $items .= '</div>';

            // Indicators
            $ind .= '<li data-target="#'.$name.'" data-slide-to="'.$i.'" class="'.$class.'"></li>';
            $class = '';
        }
        $ind = '<ol class="carousel-indicators">'.$ind.'</ol>';

        $carousel = $ind.'<div class="carousel-inner">'.$items.'</div>';
        if($lazy){
            // Image loading icon
            $carousel .= '<div class="loading hide"><img src="lib/lazy-carousel/img/black.png"/></div>';
        }
        // carousel nav
        $carousel .= '<a class="carousel-control left" href="#main-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';
        $carousel .= '<a class="carousel-control right" href="#main-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>';
        return '<div id="main-carousel" class="carousel slide" data-ride="carousel">'.$carousel.'</div>';
    }

    public static function img($src, $class = '', $responsive = true)
    {
        $class = 'class="' . $class;
        $noscript = '';
        $img = '<img src="';
        
        if ($responsive) {
            $img .= 'public/img/ajax-loader.gif" ';
            $class .= ' resize js_show loading_image';
            $img .= 'rel="';
            $noscript = '<noscript><img src="' . $src . '" /></noscript>';
        }
        
        $img .= $src . '" ' . $class . '">' . $noscript;
        return $img;
    }

    public static function a_img($src, $href, $class = 'thumbnail', $responsive = true, $toggle = '')
    {
        $a_img = self::img($src, $class, $responsive);
        $a_img = '<a ' . $toggle . ' href="' . $href . '" >' . $a_img . '</a>';
        return $a_img;
    }

    public static function calendar($dateString)
    {
        $date = strtotime($dateString);
        $day = date('j', $date);
        $month = date('F', $date);
        $calendar = '<span class="month">' . $month . '</span>';
        $calendar = '<div id="icon"><div class="calendar">' . $calendar . $day . '</div></div>';
        return $calendar;
    }

    public static function a_calendar($href, $dateString, $class = '', $toggle = '')
    {
        $calendar = self::calendar($dateString);
        $calendar = '<a ' . $toggle . ' href="' . $href . '" class="' . $class . '">' . $calendar . '</a>';
        return $calendar;
    }
}