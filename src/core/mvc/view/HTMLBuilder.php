<?php

abstract class HTMLBuilder
{

    public static function img($src, $class = '', $responsive = true)
    {
        $class = 'class="' . $class;
        $noscript = '';
        $img = '<img src="';
        
        if ($responsive)
        {
            $img .= 'public/img/ajax-loader.gif" ';
            $class .= ' resize js_show loading_image';
            $img .= 'rel="';
            $noscript = '<noscript><img src="' . $src . '" /></noscript>';
        }
        
        $img .= $src . '" ' . $class . '">'.$noscript;
        return $img;
    }

    public static function a_img($src, $href, $class = 'thumbnail', $responsive = true, $toggle = '')
    {
        $a_img = self::img($src, $class, $responsive);
        $a_img = '<a '.$toggle.' href="' . $href . '" >'.$a_img.'</a>';
        return $a_img;
    }
    
    public static function calendar($dateString)
    {
        $date = strtotime($dateString);
        $day = date('j', $date);
        $month = date('F', $date);
        $calendar = '<span class="month">'.$month.'</span>';
        $calendar = '<div id="icon"><div class="calendar">'.$calendar.$day.'</div></div>';
        return $calendar;
    }
    
    public static function a_calendar($href, $dateString, $class = '', $toggle = '')
    {
        $calendar = self::calendar($dateString);
        $calendar = '<a '.$toggle.' href="' . $href . '" class="'.$class.'">'.$calendar.'</a>';
        return $calendar;
    }
    
}