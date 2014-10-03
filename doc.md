# MarkdownBlog


## Configuration

### Configuration files
#### i) general.ini
In this configuration file the most important information for your website are stored.
``` ini
; configuration of the HTML head 
[head]
title = "SampleBlog"
favicon = "public/img/favicon.png"
	
; search engine optimization
seo[] = ""

; footer configuration
[footer]
; legal_notice = ""

; further configuration
[general]
; name of the shown on the left in the navigation
page_name = "SampleBlog"
; enable / disable syntax highlighting
highlight = true
; style sheet defining syntax highlighting scheme
scheme = "okaidia.css"
```
#### ii) config.ini
This configuration file defines the navigation structure of your website.
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
This markdown file is displayed in case of an error. You may edit it to provide your Visitor a better experience.
``` markup
# Oh - that is bad!
Something has gone wrong.
*Sorry for the inconvenience!*

Please try to fix this by reentering the website.
```
### Search Engine Optimization
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

## Supported Navigation items
MarkdownBlog provides four different kind of navigation elements, namely those are the simple linking, directory's content linking, external linking and finally grouping multiple of them in a dropdown. 
 
### i) simple linking

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

### ii) directory's content linking 
If a list of markdowns is provided the files will be displayed in a blog like layout with a defined number of entries per page. The elements will appear ordered after their filename. So if you name the individual files like ```2014-09-24_sample_post``` and ```2014-09-28_another_important_thought``` the post of the 2014-09-28 will appear first followed by the second post.
``` markup
/
|-- content/
|   |-- 2014-09-28_sample_post.md
|   |-- 2014-09-24_another_important_thought.md
```
#### Pagination
Assuming the blog is growing and soon there are a lot more posts in the ```content ``` directory from the example above. Parsing all the files would take some time, thus it might be desirable to have pagination enabled. MarkdownBlog ```enables``` pagination if limit is set > 0 in the configuration file. Setting the limit less or equal zero will ```disable``` pagination.
``` ini
; ...
limit = 3
; ...
```
#### Categories

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

### iii) external linking 

#### Sample configuration
``` ini
; external linking sample configuration 
name = "Sample.ch"
path = "https://sample.ch"
type = "href"
```


### iv) dropdown grouping

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

## Supported content file types
It is recomended to store your local files in a folder called ```content```
### Markdown
Syntax highlighting can be enabled by adding the language of the code snippet behind the code element. ``` ` ` ` bash ```
### HTML
The generated websites can contain plain HTML and even with Twitter Bootstrap style elements.
### Linking

