# MarkdownBlog

MarkdownBlog is a lightweight blog software written in php and twitter bootstrap. Unlike as in common blog application, MarkdownBlog works without any Database. This is because MarkdownBlog uses [markdown](http://de.wikipedia.org/wiki/Markdown) files `*.md` instead. The application provides two different types of page views: One that shows a list of markdowns and one that shows a single file. Further a dropdown navigation is included, which is build dynamicaly according to file structure.

## Quick start

1. Download [markdown.tar](https://github.com/phgamper/markdown_blog/releases) and extract the archive into your servers root directory.

2. Copy your `*.md~` files on the server and link them in the configuration file `config/config.ini` by editing the example in there. Additional information could be found in the [documentation]().

3. Make sure the server has read and execution access to all linked markdown files.

4. Modify the `config/general.ini` to personalize your blog.

## Build with

- HTML 5
- PHP 5.4
- [Bootstrap 3.2](http://getbootstrap.com/)
- [Parsedown](http://parsedown.org)

## Tested on

- Google Chrome 38.x

## Releases

- 22.09.2014  v. 0.1