<?php
namespace taxo2rdf;

/**
 * A basic class for store individuals entities from IEEE taxonomy
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class IEEETerm {
    public $term;
    public $level;
    protected $parent=false;
    
    function getParent() {
        return $this->parent;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

        function getTerm() {
        return $this->term;
    }

    function getLevel() {
        return $this->level;
    }

    function setTerm($term) {
        $this->term = $term;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function __construct($term, $level) {
        $this->term = $term;
        $this->level = $level;
    }

 public function toString(){
     $m="Term: ".$this->term.", level: ".$this->level;
     if ($this->parent) {
         $m.=", parent: ".$this->parent;     
     }     
     echo $m.  \PHP_EOL;
 }
    
    

}
