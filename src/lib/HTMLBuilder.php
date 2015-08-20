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
    public static function owl_carousel(array $image){
        Head::getInstance()->link('lib/owl-carousel/css/owl.carousel.css');
        Head::getInstance()->link('lib/owl-carousel/css/owl.theme.css');
        Script::getInstance()->link('lib/owl-carousel/js/owl.carousel.js');
        Head::getInstance()->link('lib/owl-carousel/css/lazy_load.css');
        Script::getInstance()->link('lib/owl-carousel/js/lazy_load.js');
        $items = '';
        foreach ($image as $i){
            $items .= '<div class="item"><img class="lazyOwl" data-src="'.$i.'" /></div>';
        }
        return '<div id="carousel" class="owl-carousel owl-theme">'.$items.'</div>';
    }

    public static function img($src, $class = '', $responsive = true, $attr = '')
    {
        $class = 'class="' . $class;
        $noscript = '';
        $img = '<img '.$attr.' src="';
        
        if ($responsive) {
            $img .= 'public/img/ajax-loader.gif" ';
            $class .= ' resize js_show loading_image';
            $img .= 'rel="';
            $noscript = '<noscript><img src="' . $src . '" /></noscript>';
        }
        
        $img .= $src . '" ' . $class . '">' . $noscript;
        return $img;
    }

    public static function a_img($src, $href, $class = 'thumbnail', $responsive = true, $toggle = '', $attr = '')
    {
        $a_img = self::img($src, $class, $responsive, $attr);
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