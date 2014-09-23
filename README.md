# MarkdownBlog

MarkdownBlog is a lightweight blog software written in php and twitter bootstrap. Its purpose is to provide a easy way to share your thoughts without any database or special setup needed.
The content of the website can be provided in easy to use [markdown](http://de.wikipedia.org/wiki/Markdown) files `(*.md)` instead. 

## Features
- Dynamic setup of your blog or website with simple configuration files but without any need of programming.
- Different views generated by your markdown files:
  - A single page to show special content like 'Contact' or 'About'.
  - A ordered list of markdowns (the sample usecase of a blog)
  - Grouping topics in a dynamicly generated dropdown menue.
- Full responsive design due to the use of Twitter Bootstrap.

## Quick start

1. Download [markdown.tar](https://github.com/phgamper/markdown_blog/releases) and extract the archive into your server's web folder. 
2. Modify the `config/general.ini` to personalize your website/blog.
3. Copy your `*.md` files on the server and provide their location in the `config/config.ini` (just edit the given example in there). 
4. Make sure the server has read and execution access to all linked markdown files.
5. Share your thoughts and enjoy!

For detailed information see the [documentation](https://github.com/phgamper/markdown_blog/blob/master/doc.md).

## Build with

- [Parsedown](http://parsedown.org)
- [Bootstrap 3.2](http://getbootstrap.com/)
- HTML 5
- PHP 5.4

## Tested on

- Google Chrome 38.x
- Safari on iOS 8
- Google Chrome for iOS 37.x
- Google Chrome for Android 37.x
- Mozilla Firefox for Ubuntu 31.0

## Releases

- 22.09.2014  v0.1 - initial release
