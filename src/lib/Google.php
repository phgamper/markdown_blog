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
class Google {

    /**
     * Validates the Goolge ReCaptcha V2 Token found in the $_POST
     *
     */
    public static function validateReCaptcha(callable $success, callable $fail, array $args) {
        if(isset($_POST['g-recaptcha-response'])){
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=".getenv('GOOGLE_API_SECRET_KEY')."&response=".urlencode($_POST['g-recaptcha-response'])."&remoteip=".$_SERVER['REMOTE_ADDR'];
            $response = json_decode(file_get_contents($url), true);
            if(intval($response["success"]) !== 1) {
                Slack::getInstance()->notify("Spam detected. Form submission blocked", ':boom:');
                $fail();
            } else {
                Slack::getInstance()->notify("reCaptcha v2 validated successfully", ':success:');
                $success($args);
            }
        } else {
            Slack::getInstance()->notify("Please check the the captcha form.", ':boom:');
            $fail();
        }
    }



}
