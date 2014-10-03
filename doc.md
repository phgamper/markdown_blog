# MarkdownBlog


## 1 Configuration

### 1.1 Configuration files
#### i) general.ini
In this configuration file the most important information for your website are stored. The individual attributes should be pretty self-explanatory or at least enought meaningful by looking at the following sample.
``` ini
; configuration of the page head 
[head]
title = "SampleBlog"
favicon = "public/img/favicon.png"

; configuration of the page footer
[footer]
legal_notice = "maintained by phgamper | phgamper [at] gmail.com"

; further configuration
[general]
; brand of the page shown on the left in the navigation
page_name = "SampleBlog"
; enable / disable syntax highlighting
highlight = true
; style sheet defining the syntax highlighting scheme
scheme = "okaidia.css"
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

; html file configuration  
[home]
name = "home"
path = "content/sample.html"
type = "html"
footer = true
logger = true

; markdown file configuration
[about]
name = "about"
path = "content/about.md"
type = "md"
footer = true
logger = true

; external links configuration
[google]
name = "Search on Google"
path = "https://google.ch"
type = "link"

; directory's content configuration
[blog]
name = "blog"
path = "content/blog/"
type = "md"
limit = 3
footer = true
logger = true

; dropdown configuration
[University]
name = "University"
footer = true
logger = true
; a single markdown file
first.name = "First semester"
first.path = "content/first.md"
first.type = "md"
first.footer = true
first.logger = true
; a list of html files
second.name = "Second semester"
second.path = "content/second/"
second.type = "html"
second.limit = 3
second.footer = true
second.logger = true
; add more entries here ...
```

#### iii) error.md
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
	meta = copyright => GPL v3.0 License
	meta = viewport => width=device-width, initial-scale=1.0
-->
```

## 2 Supported Navigation items
MarkdownBlog provides four different kind of navigation elements, namely those are the simple linking, directory's content linking, external linking and finally grouping multiple of them in a dropdown. 
 
### 2.1 simple linking

#### Sample configuration
``` ini
; simple linking sample
[home]
name = "Home"
path = "README.md"
type = "md"
footer = true
logger = true
```

### 2.2 directory's content linking 
If a list of markdowns is provided the files will be displayed in a blog like layout with a defined number of entries per page. The elements will appear ordered after their filename. So if you name the individual files like ```2014-09-24_sample_post``` and ```2014-09-28_another_important_thought``` the post of the 2014-09-28 will appear first followed by the second post.
``` markup
/
|-- content/
|   |-- 2014-09-28_sample_post.md
|   |-- 2014-09-24_another_important_thought.md
```
#### i) Pagination
Assuming the blog is growing and soon there are a lot more posts in the ```content ``` directory from the example above. Parsing all the files would take some time, thus it might be desirable to have pagination enabled. MarkdownBlog ```enables``` pagination if limit is set > 0 in the configuration file. Setting the limit less or equal zero will ```disable``` pagination.
``` ini
; ...
limit = 3
; ...
```
#### ii) Categories

#### Sample configuration
``` ini
; directory's content linking sample configuration
name = "list"
path = "content/"
type = "md"
limit = 3
footer = true
logger = true
```

### 2.3 external linking 

#### Sample configuration
``` ini
; external linking sample configuration 
name = "Sample.ch"
path = "https://sample.ch"
type = "href"
```


### 2.4 dropdown grouping

#### Sample configuration
``` ini
; dropdown grouping sample configuration
[wurst]
name = "hallo"
path = "README.md"
type = "md"
footer = true
logger = true

first.name = "first"
first.path = "content/first.md"
first.type = "md"
first.footer = true
first.logger = true

; ... more items goes here

n.name = "google.ch"
n.path = "https://google.ch"
n.type = "href"
```

## 3 Supported content file types
It is recommended to store your local files in a folder called ```content```
### 3.1 Markdown
Syntax highlighting can be enabled by adding the language of the code snippet behind the code element. ``` ` ` ` bash ```
### 3.2 HTML
The generated websites can contain plain HTML and even with Twitter Bootstrap style elements.
### 3.3 Linking

