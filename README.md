#IEEE taxonomy to rdf

##Intro

The aim of this project is to get the information in [IEEE taxonomy](http://www.ieee.org/documents/taxonomy_v101.pdf) in a more suitable format. 

##Information

This is a php project for the comand line. The version used was php 5.6. 

##How to use 

1. Obtain the IEEE taxonomy and transform to a txt file (for example with [Apache pdfbox](http://pdfbox.apache.org/)). 
2. Remove the lines with two entities in it (like ....Entity1........Entity2). I have done 
it with [geany](http://www.geany.org/) and the regex \w\.+\w
2. Be sure that all lines starting with upper case are a proper term in the taxonomy. Pay attention
to the IEEE part.
3. Then use index.php and instead of the test file ultra_mini.txt put your file.
4. The result will be in **resources** as **ieeeTaxonomyOWL.owl**.
5. If there are some spaces in the end of some words (the last in the original pdf) it is possible to remove
them select these spaces in a term and delete all them with geany or other editor.



##Test

Some simple [PHPUnit](https://phpunit.de/) test are provided.


##Author and license 

Creator: Guillem LLuch Moll guillem72 gmail.com

License: GPL  
