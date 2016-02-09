<?php
namespace taxo2rdf;
//file_put_contents($this->file_target,json_encode($this->processed, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));	
include_once __DIR__.'/classes/IEEEParser.php';
include_once __DIR__.'/classes/IEEEReader.php';
include_once __DIR__.'/classes/WriteOwl.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$reader=new IEEEReader(__DIR__."/resources/test/ultra_mini.txt");
$lines=$reader->read();
//\var_dump($lines);
$parser=new IEEEParser($lines);
$arr=$parser->parse();
//\var_dump($arr);
//file_put_contents(__DIR__."/resources/test/ultra_mini_result.json",json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));	
//file_put_contents(__DIR__."/resources/test/ultra_mini_Parser_result.ser",  \serialize($arr));
 $ori=__DIR__."/resources/ieeeTaxoOWL-start.owl";
 $target= __DIR__."/resources/ieeeTaxonomyOWL.owl";
$writer=new WriteOwl($ori,$target);
if ($writer->write($arr) === false) {
    echo "ERROR writing the file".PHP_EOL;
}
else{
    echo "Work Done".PHP_EOL;
}

