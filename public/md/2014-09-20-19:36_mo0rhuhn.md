Seminar parallel computing
==========================

Term paper for the Zurich university of applied sciences seminar in parallel computing.

This paper aims to check for a possible correlation of sentiments and chosen values in a specified period.
The sentiment analysis is done with the Standord Core NLP framework.
For the parallel computation an own Java based Map-Reduce framework is used.

**Sample Case:**

1. Analysis of given Twitter data for London
2. Check for a possible correlation with the FTSE 100 trend in the given period

Usage:
-------------
To perform a analysis three steps are needed: 

1. Configuration of the input CSV
2. Computation of the sentiments
3. Comperation with some values you like plotted in a nice graph

![alt text](https://raw.githubusercontent.com/mxmo0rhuhn/seminar_parallel_computing/master/pictures/Overview.png "The application overview")

In the overview you can choose the inputfile, the output file and the File you want to compare your data with. 
It is also possible to launch each of the three steps and to view the log.

![alt text](https://raw.githubusercontent.com/mxmo0rhuhn/seminar_parallel_computing/master/pictures/MAP_config.png "MAP step configuration ")

As configuration of the sentiment computation you have to choose a date field as well as the text field in your data. You also have to specify the in and out format of the date field. 
If a timestamp exists more than once after the transformation of input to output format the average value of all given data is calculated.
If you like you may also enable a logging of part results, e.g. as a kind of audit trail, on each of the workers that are part of your computation.

![alt text](https://raw.githubusercontent.com/mxmo0rhuhn/seminar_parallel_computing/master/pictures/Comparison_config.png "Comparison configuration ")

For the final comparison of the file other data you may specify the timestamp and value field of your data and again the input and output format of the timestamp. 
Again, if the same timestamp has multiple values after transformation a average value is computed and displayed in the graph.

![alt text](https://raw.githubusercontent.com/mxmo0rhuhn/seminar_parallel_computing/master/pictures/Sample.png "Sample output")

The output of your comparison may look like this.

Just download and have some fun ;)


Dependencies:
-------------

1. [Stanford Core NLP] (https://github.com/stanfordnlp/CoreNLP)
2. [A older term paper is used for map-reduce] (https://github.com/mxmo0rhuhn/map-reduce)
3. [JFreeChart] (https://github.com/jfree/jfreechart-fse)

License:
-------------

This term paper is free software: You can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

The file is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
