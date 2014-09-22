# SonarQube File Parser Plugin

This SonarQube Plugin parses a property file and dynamicly displays the content.
It can be useful if you want to display custom configuration parameters in the SonarQube dashboard or so on.
You can specify titles for groups, single lines or key value pairs.

## Sample
A property file like this:

```
G=This is a title 
K=Key value pairs=Possible
L=Or just a simple lines
L=The strings are not escaped - so you can use your own <em>HTML Code</em> inside
G=This is another title
K=Even cool booleans=true
K=With pictures if you like=false
G=Titles help you to display content well structured
K=Question=42
K=My important KPI=1
K=Another important KPI=2
K=Some other stuff i'd like to show=3
K=Followed by some numbers=5
```

... will be displayed as:

![alt text](https://raw.githubusercontent.com/mxmo0rhuhn/sonarQubeFileParser/master/sample.png "A sample of some Properties")

All seperators or prefixes are configurable so you can change it to fit your needs.
E.g. you can change the seperator to any other string to have the possibility to bisplay hyperlinks.



Boolean pictures: "Must Have" by [Visual Pharm](http://icons8.com/) distributed under [Creative Commons (Attribution 3.0 Unported)](http://creativecommons.org/licenses/by-nd/3.0/)

This plugin is free software: You can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
