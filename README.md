#IEEE taxonomy to rdf

##Intro

The aim of this project is to get the information in [IEEE taxonomy](http://www.ieee.org/documents/taxonomy_v101.pdf) in a more suitable format. 

##Information

This is a php project for the comand line. It is not still complete.

##How to use 

1. Obtain the IEEE taxonomy and transform to a txt file (for example with [Apache pdfbox](http://pdfbox.apache.org/)). 
2. Remove the lines with two entities in it (like ....Entity1........Entity2). I have done 
it with [geany](http://www.geany.org/) and the regex \w\.+\w
3. Then use index.php, instead of the test file ultra_mini.txt put your file.



##Test

Some simple [PHPUnit](https://phpunit.de/) test are provided.


##Author and license 

Creator: Guillem LLuch Moll guillem72 gmail.com

License: GPL  
