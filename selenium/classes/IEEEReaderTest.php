<?php
namespace taxo2rdf;


//require_once '/root/public_html/ieeeTaxo2rdf/classes/IEEEReader.php';
require_once __DIR__.'../../../classes/IEEEReader.php';


/**
 * Description of IEEEReaderTest
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class IEEEReaderTest extends \PHPUnit_Framework_TestCase {

    protected $file;
    protected $result;
    
    function __construct() {
        $this->file=__DIR__."../../../resources/test/ultra_mini.txt";
        $this->result=__DIR__."../../../resources/test/ultra_mini_result.ser";
    }

        public function testMiniFile(){
        $solution=  unserialize(file_get_contents($this->result));
        $reader=new IEEEReader($this->file);
        $lines=$reader->read();
        
        $this->assertEquals($solution,$lines);
    }
    
    
}
