<?php

namespace taxo2rdf;

require_once __DIR__.'../../../classes/IEEEParser.php';
require_once __DIR__.'../../../classes/IEEEReader.php';
/**
 * Description of IEEEParserTest
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class IEEEParserTest extends \PHPUnit_Framework_TestCase {
    protected $file;
    protected $result;
    
    function __construct() {
        $this->file=__DIR__."../../../resources/test/ultra_mini.txt";
        $this->result=__DIR__."../../../resources/test/ultra_mini_Parser_result.ser";
    }
    
    
    public function testParser(){
        $reader=new IEEEReader($this->file);
        $lines=$reader->read();
        $parser=new IEEEParser($lines);
        $arr=$parser->parse();
        $solution=  unserialize(file_get_contents($this->result));
         $this->assertEquals($solution,$arr);
    }
   

}
