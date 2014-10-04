<!--
	author = <a href="https://github.com/phgamper" target="_blank">phgamper</a>
	published = 2014-09-28
-->

# MarkdownBlog

MarkdownBlog is a lightweight blog software written in php and twitter bootstrap. Its purpose is to provide a easy way to share your thoughts without any database or special setup needed.
The content of the website can be provided in easy to use [markdown](http://de.wikipedia.org/wiki/Markdown) files `(*.md)` instead. 

## Features
- Dynamic setup of your blog or website with simple configuration files but without any need of programming.
- Support for (remote) markdown and HTML files
- Easy to build navigation, including the ability to link external sites
- Different views generated with your markdown or html files:
  - Single pages to show special content like 'Contact' or 'About'.
  - Remote pages to show content hosted on an onther server (e.g. your favourite GitHub project).
  - List of markdown files (the sample usecase of a blog)
  - Grouping of topics in a dynamicly generated dropdown menue.
- Full responsive design due to the use of Twitter Bootstrap.
- Syntax highlighting for both HTML and markdown
- Extended support for blogs
  - Search for categories
  - Display content on several pages to ensure fast loading

## Quick start

1. Download [markdown.zip](https://github.com/phgamper/markdown_blog/releases) and extract the archive into your server's web folder. 
2. Edit your webservers `DocumentRoot` to point at the projects `public` folder
3. Modify the `config/general.ini` to personalize your website/blog. A sample configuration is provided in the `config/general.ini.sample`.
4. Copy your `*.md` files on the server (e.g. `public/content/` and provide their location in the `config/config.ini`. 
5. Make sure the server has read and execution access to all linked markdown files.
6. Share your thoughts and enjoy!

For detailed information see the [documentation](https://github.com/phgamper/markdown_blog/blob/master/doc.md).

## Build with

- [Parsedown](http://parsedown.org)
- [IniParser](https://github.com/austinhyde/IniParser)
- [prismjs](http://prismjs.com/index.html)
- [Bootstrap 3.2](http://getbootstrap.com)
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
