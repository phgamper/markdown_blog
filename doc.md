# MarkdownBlog

> Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.

<!--
## 0 Index of Contents

   [1 Configuration](#1)
   
   [2 Supported Navigation items](#2)
   
   [3 Supported content file types](#3)
   
   [4 Additional/Special Features](#4)
   
   [5 Security Settings](#5)
-->

## 1 Configuration

### 1.1 Configuration files 

#### i) general.ini
In this configuration file the most important information for your website are stored. The individual attributes should be pretty self-explanatory or at least enought meaningful by looking at the following sample.
``` ini
[general]
; Page name (shown on the left in the navigation)
page_name = "SampleBlog"

[head]
; Title displayed in the browser
title = "SampleBlog"
; Icon displayed in the browser
favicon = "img/favicon.png"

; Meta information for search engines etc. 
; These information will be included in every file if not defined otherwise
meta.author = "phgamper"
meta.copyright = "Philipp Gamper"
meta.description = "Sample project to show the capabilities of the MarkdownBlog"
meta.keywords = "markdown,sample,blog"

[footer]
; Content displayed in the footer
legal_notice = "maintained by phgamper | phgamper [at] gmail.com"
```

#### ii) config.ini
This configuration file defines the navigation structure of your website. An item of the navigation is represented by an identifier in brackets followed by attributes related to it, i.e.
``` ini
; ...
[home]
name = "Home"
; ...
```
Some of the attributes are mandatory some are not. Those one that must be set, are ```name```, ```path``` and ```type```. The former defines the description of the button and may contain any UTF-8 character, while the latter specifies the type of the content file to parse. The second is a bit more involved. If a path to a file is given, MarkdownBlog will simply parse and include its content. If a path to a directory is given, MarkdownBlog will parse all files contained in the folder and include them in a blog like manner. Valid types are ```html``` for linking HTML file/s, ```md``` for linking markdown file/s and ```href``` for linking to an external location. All remaining attributes are optional. Namely those are ```limit``` which enables pagination after a specified number of entries, ```footer``` which indicates the footer to be shown or not, and ```logger``` which enables/disables the logger.

Missing or wrong defined mandatory attributes result in showing an error page, while the absence or incorrectness of optional attributes only result in default behavior, e.g. not showing the footer. Syntax errors lead to an error page as well as they might cause the navigation is not displayed properly.

All of above named attributes may be combined with each other as desired. A sample configuration with most possible combination is shown below.
``` ini
; sample configuration for the website structure
; ---------------------

; html file configuration sample  
[home]
name = "home"
path = "content/sample.html"
type = "html"
footer = false

; include external links into navigation
[google]
name = "Markdown Blog project"
path = "https://github.com/phgamper/markdown_blog"
type = "link"

; list all *.md contained in a directory
[blog]
name = "blog"
path = "content/blog/"
type = "md"
limit = 3

; Dropdown in navigation
[University]
name = "University"
;a single markdown file
first.name = "First semester"
first.path = "content/first.md"
first.type = "md"
; a list of html files
second.name = "Second semester"
second.path = "content/second/"
second.type = "html"
second.limit = 3
; simple file for display
[about]
name = "about"
path = "content/about.md"
type = "md"

; add more entries here ...
```

#### iii) defaults.ini
Unlike the other configuration files ```defaults.ini``` is not located in ```config/``` but in ```src/```. This is because it contains some carefully chosen defaults. And therefore it should not be modified, unless the editor does absolutely know, what he is doing. It's recommended rather to edit ```config/general.ini```, since its definitions have the higher priority and thus overwrite their defaults.         
``` ini
; Do not modify this file - it just provides the default configuration. 
; If you like to edit settings provided in here please change the config/general.ini
; all attributes of config/general.ini overwrite definitions made in this file.

[head]
; Default robots config
meta.robots = "INDEX,FOLLOW"
meta.viewport = "width=device-width, initial-scale=1.0"

[general]
; enable / disable syntax highlighting
highlight = true
; style sheet defining syntax highlighting scheme
scheme = "okaidia.css"

[footer]
; please give our project credit!
poweredby = 'Proudly powered by <a href="https://github.com/phgamper/markdown_blog" title="MarkdownBlog on github">MarkdownBlog</a> 2014 - GPL v3.0'
```

#### iv) error.md
As stated in the section above, it might happen that something goes wrong. MarkdownBlog includes an error handling that deals with such cases, i.e. those include URL modification, configuration file errors, permission errors, etc. The following markdown file is displayed in case of an error. Certainly it could be adapted to one's personal wishes.
``` markup
# Oh - that is bad!
Something has gone wrong.
*Sorry for the inconvenience!*
```


### 1.2 Search Engine Optimization
#### i) meta-tags
MarkdownBlog allows to customize the ```HTML meta tags``` per page by simply providing them as key-value pairs in the content header. For more details see *supported content file types* 
``` markup
<!--
	...
	meta = description => README.md of MarkdownBlog
	meta = keywords => markdown,readme
	meta = author => phgamper
	meta = copyright => Philipp Gamper 
	meta = viewport => width=device-width, initial-scale=1.0
-->
```



## 2 Supported Navigation items
MarkdownBlog provides five different kind of navigation elements, i.e. the simple linking, remote linking, directory's content linking, external linking and finally grouping multiple of them in a dropdown. 
 

### 2.1 simple linking
The *simple linking* approach provides, like stated by its name, the opportunity to simply include a single document no matter whether it is a HTML or a markdown file. The only restriction is, that a HTML document must not contain tags describing any non-structural tags like html, head, body, footer, etc., since they are still defined by the MarkdownBlog itself. The following sample configuration should be prety self-explanatory.

#### i) Sample configuration
``` ini
; simple linking sample
[home]
name = "Home"
path = "README.md"
type = "md"
```


### 2.2 remote linking
The *remote linking* works pretty similar to the *simple linking*. Its only difference is, that the document have not to be stored locally. The additional attribute ```link``` is optional and is used to include a reference to the remote content on top. Note, that *remote linking* only works for markdown and not for HTML files. Again the following sample configuration should be pretty self-explanatory.

#### i) Sample configuration
``` ini
; remote linking sample
[remote]
name = "MarkdownBlog"
path = "https://raw.githubusercontent.com/phgamper/markdown_blog/master/README.md"
type = "remote"
link = "https://github.com/phgamper/markdown
```


### 2.3 directory's content linking 
If a list of markdowns is provided the files will be displayed in a blog like layout with a defined number of entries per page. The elements will appear ordered after their filename. So if you name the individual files like ```2014-09-24_sample_post``` and ```2014-09-28_another_important_thought``` as shown in the following figure, the post of the 2014-09-28 will appear first followed by the second post.
``` markup
/
|-- content/
|   |-- 2014-09-24_another_important_thought.md
|   |-- 2014-09-28_sample_post.md
```

#### i) Pagination
Assuming the blog is growing and soon there are a lot more posts in the ```content ``` directory from the example above. Parsing all the files would take some time, thus it might be desirable to have pagination enabled. MarkdownBlog ```enables``` pagination if limit is set > 0 in the configuration file. Setting the limit less or equal zero will ```disable``` pagination.
``` ini
; ...
limit = 3
; ...
```

#### ii) Categories
Considering again the example from above, a user often wishes to filter by certain keywords. MarkdownBlog implements an easy to use filtering by hashtags. Similar to the ability of defining the meta tags, it is possible to assign each post to as many categories as desired. Therefore it exists the predefined placeholder ```category``` in the document header, which takes a semicolon separated string that finally is exploded into a set of categories assigned on top of the entry. Clicking on such a tag triggers the page only showing posts assigned to even this category.

Generally the usage of this feature should not result in any exceptional behaviour, except for syntax errors in the document header. Since the category tag is optional, its absence leads to not showing any hashstag at all. Even modifying the URL manually, directs at most in an empty page, if the entered tag would not match any. The following figure provides a sample of how categories are defined.
``` markup
<!--
	...
	category = gentoo;apple time machine;server;backup
    ...
-->
```

#### iii) Sample configuration
The sample below shows how to configure MarkdownBlog to list the content of a directory in a manner described above. Compared to *simple linking* the ```path``` attribute is slightly different. Further there is an additional attribute ```limit```, which leads to the behavior described in the pagination section. 
``` ini
; directory's content linking sample configuration
[blog]
name = "list"
path = "content/"
type = "md"
limit = 3
footer = true
logger = true
```


### 2.4 external linking 
As the name implies, *external linking* provides the possibility to integrate any URL of choice into the navigation. Therefore ```path``` is used to specify the URL and ```type``` must be set to ```href```. A sample configuration is provided below.
 
#### i) Sample configuration
``` ini
; external linking sample configuration 
name = "Sample.ch"
path = "https://sample.ch"
type = "href"
```



### 2.5 dropdown grouping
As stated at the beginning of section 2, Markdown allows grouping multiple of the above discussed navigation elements in a dropdown. This is done by adding a prefix, e.g. ```first.```. The rest should be clear by considering the sample configuration below.
 
#### i) Sample configuration
``` ini
; Dropdown in navigation
[University]
name = "University"
;a single markdown file
first.name = "First semester"
first.path = "content/first.md"
first.type = "md"
; a list of html files
second.name = "Second semester"
second.path = "content/second/"
second.type = "html"
second.limit = 3
; simple file for display
[about]
name = "about"
path = "content/about.md"
type = "md"

; add more entries here ...
```


## 3 Additional/Special Features


### 3.1 document header

``` markup
<!--
	author = <a href="https://github.com/phgamper" target="_blank">phgamper</a>
	published = 2014-09-28
	category = gentoo;apple time machine;server;backup
    meta = copyright => Philipp Gamper
    ...
-->
```


## 4 Security Settings

### 4.1 Web root folder

``` apacheconf
DocumentRoot "/var/www/localhost/htdocs"
``` 

### 4.2 Content root folder
It is recommended to store your local files in a folder called ```content```.

### 4.3 ACL permission settings
To avoid exeptional behavior caused by missing permission. The apache should either own all files or at least be assigned to the group. The latter is recommended, since the former requires the administrator to be in the apache group. In addition new content is owned by the creator by default, what implies that apache might have restricted access.     
 
``` bash
chwon -R user:apache .
```
Directories must be executable to be browsed and to allow apache execute PHP scripts in there, while files rather should not be executable, to prevent an attacker from executing injected code.
``` bash
chmod 750 directory/
chmod 640 file.php
# chmod all php files at once
find . -iname "*.php" | xargs chmod 640
```
  
**_Note:_** If MarkdownBlog was cloned from git, it's recommended not to use root to execute the git commands, since that will make root the owner of the cloned files.

