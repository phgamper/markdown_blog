# MarkdownBlog

MarkdownBlog is a lightweight php blog software. 
Its purpose is to provide a easy way to share your thoughts without any database or special setup needed.
The content of the website can be provided in easy to use [markdown](http://de.wikipedia.org/wiki/Markdown) files `(*.md)` instead of other more complicated solutions. 

## Features

- Dynamic setup of your blog or website with simple configuration files but without any need of programming.
- Support for (remote) markdown and HTML files
- Easy to build navigation, including the ability to link external sites
- Different views generated with your markdown or html files:
  - Single pages to show special content like 'Contact' or 'About'.
  - Remote pages to show content hosted on an onther server (e.g. your favourite GitHub project).
  - List of markdown files (the sample usecase of a blog)
  - Grouping of topics in a dynamicly generated dropdown menue.
- Syntax highlighting for both HTML and markdown
- Build-in Gallery, including a lazy-load slider
- Dynamic image resize to minimize network traffic
- Extended support for blogs
  - Search for categories
  - Display content on several pages to ensure fast loading
- Mail obfuscation

## Quick start

1. Download [markdown.zip](https://github.com/phgamper/markdown_blog/releases) and extract the archive into your server's web folder. 
2. Edit your webservers `DocumentRoot` to point at the projects `public` folder
3. Modify the `config/general.ini` to personalize your website/blog. A sample configuration is provided in the `config/general.ini.sample`.
4. Copy your `*.md` files on the server (e.g. `public/content/` and provide their location in the `config/config.ini`. 
5. Make sure the server has read and execution access to all linked markdown files.
6. Share your thoughts and enjoy!

You should probably exclude .git and .ini files from being served by your web server.
A full example of a Apache configuration can be found in the `apache.conf` in this repo.

For detailed information see the [documentation](https://github.com/phgamper/markdown_blog/blob/master/doc.md).

### Docker

Markdown Blog provides a Dockerfile for a easy installation. 

For a test you can follow these steps: 

1. Download [markdown.zip](https://github.com/phgamper/markdown_blog/releases) 
2. Extract it on your local hard disk and `cd` into it
3. `docker build -t YOUR_NAME/mdblog . `in the MarkdownBlog folder (where YOUR_NAME equals a distinctive string)
4. Switch to your website folder 
5. `docker run -v $(pwd)/:/var/www/html/public/content -v $(pwd)/.config/:/var/www/html/config -p 8080:443 YOUR_NAME/mdblog` (where $(pwd) equals the path of your website folder)
6. You can access your MarkdownBlog via https://localhost:8080/

__Note:__ Debug your PHP in Docker with Intellij/PHPStorm and Xdebug [see here](https://gist.github.com/chadrien/c90927ec2d160ffea9c4)
1. `docker run -e XDEBUG_CONFIG="remote_host=YOUR_IP_ADDRESS" -v $(pwd)/:/var/www/html/public/content -v $(pwd)/.config/:/var/www/html/config -p 8080:443 YOUR_NAME/mdblog` (where $(pwd) equals the path of your website folder)
2. In Intellij/PHPStorm go to: `Languages & Frameworks > PHP > Debug > DBGp Proxy` and set the following settings: `Host: YOUR_IP_ADDRESS` `Port: 9000`

__Note:__ This setup is only suited for testing purposes. You Should definitely replace the self signed certificate that is generated in the docker container with a real SSL Cert.
- Your public key ("domain.pem") and the intermediate Certificates ("intermediate.pem") have to be linked into _/etc/ssl/certs_.
- Your private key ("domain.key") has to be linked into _etc/ssl/private_

Furthermore you might want to add custom CA authorities ("ca-bundle.crt") into the _/etc/apache2/ssl.crt_ folder and export the logs _/var/log/httpd_.


## Build with

- [Parsedown](http://parsedown.org)
- [IniParser](https://github.com/austinhyde/IniParser)
- [prismjs](http://prismjs.com/index.html)
- [PhotoSwipe](http://photoswipe.com/)
- [Font Awesome](https://fortawesome.github.io/Font-Awesome/)
- HTML 5
- PHP 5.6
