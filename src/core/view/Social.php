<?php

/**
 * This file is part of the MarkdownBlog project.
 * TODO ...
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
class Social
{
    private $socials = array();

    private static $instance = null;

    private function __construct()
    {
       $this->socials = Config::getInstance()->getGeneralArray('social');
    }

    private function __clone() {}

    /**
     * returns the instance created by its first invoke.
     *
     * @return Social
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function socialButtons($link, $name = '', $desc = ''){
        $socials = array();
        if (array_key_exists('facebook', $this->socials) && $this->socials['facebook']) {
            $item = '<a href="https://www.facebook.com/sharer/sharer.php?u='.$link.'">';
            $item .= '<i class="fa fa-2x fa-facebook-square wow bounceIn" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: bounceIn;"> </i></a>';
            $socials[] = $item;
        }
        if (array_key_exists('twitter', $this->socials) && $this->socials['twitter']) {
            $item = '<a href="https://twitter.com/intent/tweet?original_referer='.$link.'&text='.$name.'&tw_p=tweetbutton&url='.$link.'">';
            $item .= '<i class="fa fa-2x fa-twitter-square wow bounceIn" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: bounceIn;"> </i> </a>';
            $socials[] = $item;
        }
        if (array_key_exists('gplus', $this->socials) && $this->socials['gplus']) {
            $item = '<a href="https://plus.google.com/share?url='.$link.'">';
            $item .= '<i class="fa fa-2x fa-google-plus-square wow bounceIn" data-wow-delay=".3s" style="visibility: visible; animation-delay: 0.3s; animation-name: bounceIn;"> </i> </a>';
            $socials[] = $item;

        }
        if (array_key_exists('linkedin', $this->socials) && $this->socials['linkedin']) {
            $item = '<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$link.'&title='.$name.'&summary='.$desc.'">';
            $item .= '<i class="fa fa-2x fa-linkedin-square wow bounceIn" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: bounceIn;"> </i> </a>';
            $socials[] = $item;
        }
        if (array_key_exists('xing', $this->socials) && $this->socials['xing']) {
            $item = '<a href="https://www.xing.com/spi/shares/new?url='.$link.'&follow_url='.$link.'">';
            $item .= '<i class="fa fa-2x fa-xing-square wow bounceIn" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: bounceIn;"> </i> </a>';
            $socials[] = $item;
        }
        if (array_key_exists('mail', $this->socials) && $this->socials['mail']) {
            $item = '<a href="mailto:?subject='.$name.'&amp;body='.$desc.'%0A%0A'.$link.'">';
            $item .= '<i class="fa fa-2x fa-envelope-square wow bounceIn" data-wow-delay=".6s" style="visibility: visible; animation-delay: 0.6s; animation-name: bounceIn;"> </i> </a>';
            $socials[] = $item;
        }
        return $socials;
    }
}
