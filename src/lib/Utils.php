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
class Utils {

    const MAIL_REGEX = '#<\s*?obfuscate\b[^>]*>(.*?)</obfuscate\b[^>]*>#s';

    public static function obfuscate($string, Script $script) {
        $script->link(JS_DIR . 'minerva.js');
        preg_match_all(self::MAIL_REGEX, $string, $matches);
        foreach ($matches[0] as $k => $m) {
            $string = str_replace($m, '<span class="minerva">'.base64_encode(str_rot13(trim($matches[1][$k]))).'</span>', $string);
        }
        return $string;
    }
    
    public static function minifyCSS($src) {
        return self::cacheFile($src);
    }

    /**
     * Assume the given source path is absolute to the Document Root,
     * i.e., let the Document Root be equal /var/www/html/public, then the following
     * file /content/myFile.txt resolves to <Document Root>/content/myFile.txt, thus
     * to /var/www/html/public/content/myFile.txt
     * A source path must not be relative as content/myFile.txt would resolve to 
     * /var/html/publicconentn/myFile.txt
     * 
     *
     * @param string $src path to file
     * @return string
     */
    public static function cacheFile($src){
        $file = $_SERVER['DOCUMENT_ROOT'].$src;
        if (!file_exists($file)){
            Logger::getInstance()->add(new Warning('No such file or directory: "'.$file.'"', 'Utils::cacheFile()'));
            return $src;
        }
        $min = CACHE_DIR.md5_file($file).'.'.pathinfo($file, PATHINFO_EXTENSION);
        if (!file_exists($min)) {
            if(!copy($file, $min)){
                Logger::getInstance()->add(new Error('Failed to copy file: "cp '.$file.' '.$min.'"', 'Utils::cacheFile()'));
            }
        }
        return '/'.$min;
    }
}


