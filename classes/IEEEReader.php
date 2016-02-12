<?php

namespace taxo2rdf;

//include_once "../../Utils/index.php";

/**
 * Read data from IEEE taxonomy and sent it in an array made by one term
 *  (and all preceding dots) per line. The class is robust against term in two diferents lines, as 
 * "............Polarimetric synthetic aperture\n
 * radar"
 * if the second line starts with lowercase. 
 * But the class doesn't separete terms in the same line as
 *  "............Adaptive arrays............Butler matrices"
 * . To avoid this issue is possible to fix the file manualy with regex \w\.+\w
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class IEEEReader {

    /**
      @var $lines string[] internal array to process the data
     *      */
    protected $lines = array();

    /**
      @var $filename string the name of the file to be process.
     * The class is robust against term in two diferents lines, as 
     * ............Polarimetric synthetic aperture
      radar
     * if the second line starts with lowercase
     *      */
    protected $filename = false;

    function getFilename() {
        return $this->filename;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * Function for reset all the initial values
     */
    public function reset() {

        $this->lines = array();
        $this->filename = false;
    }

    function __construct($filename) {
        $this->filename = $filename;
    }

//\w\.+\w

    /**

     * This function try to join terms with words in diferent lines. The second line have to start
     * in lowercase.
     * @return string[] every value is a term in the taxonomy
     *      */
    protected function lostWords() {
        $pre_words = [];
        $previous = false;
        foreach ($this->lines as $num_line => $raw_word) {
            $temporal = \str_replace(".", "", \trim($raw_word));
            if ($temporal !== "") {
                if (ucfirst($temporal) !== $temporal AND $temporal !== "pH measurement") { //no starts with Capital letter
                    if ($previous) {
                        $pre_words[] = $previous . " " . trim($raw_word);
                        $m = $raw_word . "( " . $num_line . ") has been aded to the previos one.";
                        $m.= \PHP_EOL . " Result=" . trim($previous) . " " . trim($raw_word) . PHP_EOL;
                        // echo $m;
                    }//  if ($previous)              
                } else { //else of  if (ucfirst($temporal)!==$temporal) 
                    $pre_words[] = \trim($previous);
                    $previous = $raw_word;
                }
            }
        }//foreach
        $pre_words[] = trim($this->lines[\count($this->lines) - 1]);
        return $this->isNotEmpty($pre_words);
    }

    /**
     *  Remove terms made only by white space
     * @var $values string[] The array with some values maybe equal to ""
     * @return string[] All elements of the array are different from "" 
     *      */
    protected function isNotEmpty($values) {
        $gw = [];
        foreach ($values as $value0) {
            $value=trim($value0);
            if ($value !== "") {
                
                //echo "In= " . $value0 . ", out=" . \trim($value) . "." . \PHP_EOL;
                $gw[] = \trim($value);
            }
        }
        return $gw;
    }

    

    /**
     * Read the file and return an array of terms (with dots)
     * @return string[] The terms with dots.
     */
    public function read() {
        if (!$this->filename) {
            return false;
        }
        if (\count($this->lines) > 0) {
            return $this->lines;
        }
        //$words=  \explode("............",  \file_get_contents($this->filename));

        $this->lines = \explode("\n", \file_get_contents($this->filename));
        //var_dump($lines);
        return $this->lostWords();
    }

}
