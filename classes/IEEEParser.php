<?php

namespace taxo2rdf;

include_once __DIR__ . "/IEEETerm.php";

/**
 * A class to transform the IEEE taxonomy in an array "entity => parent entity". 
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class IEEEParser {
 /**
  * @param string[] $taxonomy The final product. Is an array array "entity => parents[]"
  */
    protected $taxonomy = [];
    
     /**
  * @param string[] $taxonomyBis The final product. Is an array array "parent => childs[]"
  */
    protected $taxonomyBis = [];
    
    
    
     /**
     * @param IEEETerms[] $elements . Is the result of the function addLevels()
     */
    protected $elements = []; 
    
    /**
     * @param string[] $lines  the original array, with dots.
     */
    protected $lines = [];
    
     /**
     * @param int  $diff The number of dots which separe a child to its parent.
     */
    protected $diff = 4;

    function getTaxonomyBis() {
        return $this->taxonomyBis;
    }

        function getDiff() {
        return $this->diff;
    }

    function setDiff(the $diff) {
        $this->diff = $diff;
    }

        
    function getTaxonomy() {
        return $this->taxonomy;
    }

    /**
     * Function for reset all the initial values
     */
    public function reset() {
        $this->elements = []; //
   
        $this->lines = [];
        $this->taxonomy = [];
    }

    function __construct($lines) {
        $this->lines = $lines;
    }

    /**
     * This funtion does all the job if filename is set. For each level It save the last term in such level 
     * @return string[] . The is the word and the value is its parent.
     * 
     */
    public function parse() {
        $this->addLevels();
       
        $ultim = [];
        $ultim[-1] = "IEEE";
        $rest_words = $this->elements;
        $this->taxonomy[$rest_words[0]->term] =["IEEE"];   
        $this->taxonomyBis["IEEE"]=[$rest_words[0]->term];
        $ultim[0] = \array_shift($rest_words);
        while (\count($rest_words) > 0) {
            $actual = \array_shift($rest_words);
            $this->add($actual, $ultim);
            $ultim[$actual->level] = trim($actual->term);
        }//end while
        //var_dump($ultim);
        return $this->taxonomy;
    }
    
    protected function add($child,$candidates){
        $parent=null; 
        if (!isset($this->taxonomy[trim($child->term)])) {
                $this->taxonomy[trim($child->term)] = [];
            }
            if (\is_object($candidates[$child->level - 1])) {//sometimes is an object, sometimes is a string
               $parent=\trim($candidates[$child->level - 1]->term);
               } else {
                 $parent=  \trim($candidates[$child->level - 1]);
                //$this->taxonomy[trim($actual->term)] = trim($ultim[$actual->level - 1]);
            }
   \array_push($this->taxonomy[trim($child->term)], $parent);  
   if (!isset($this->taxonomyBis[$parent])) {
            $this->taxonomyBis[$parent] = [];
        }
   \array_push($this->taxonomyBis[$parent],  \trim($child->term));
    }

   /**
    * Build $elements as an array of IEEETerms. This terms are made essetialy of a Entity 
    * and its level in the IEEE taxonomy. Note that it depends on $diff to establish the level. 
    */
    protected function addLevels() {
        foreach ($this->lines as $line) {
            $level = $this->numDots($line) / $this->diff;
            $temporal = \trim(\str_replace(".", "", $line));
            $this->elements[] = new IEEETerm($temporal, $level);
        }
    }

    /**
     * A auxiliar function that calculates the number or dots before the entity.
     * @return int The number of dots before any char.
     */
    protected function numDots($dot_word) {
        $temporal = \str_replace(".", "", $dot_word);
        $num_dots = strlen($dot_word) - strlen($temporal);
        return $num_dots;
    }

//function
    //var_dump($prewords);
}
