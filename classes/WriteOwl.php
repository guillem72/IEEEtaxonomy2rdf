<?php

namespace taxo2rdf;

/**
 * A class to transform an array "node => [parent1, parent2...]" in a taxonomy in OWL 2.0 format
 *
 * @author Guillem LLuch Moll <guillem72@gmail.com>
 */
class WriteOwl {

    protected $startFile;
    protected $targetFile;
    protected $root = "IEEE";

    function getStartFile() {
        return $this->startFile;
    }

    function getTargetFile() {
        return $this->targetFile;
    }

    function getRoot() {
        return $this->root;
    }

    function setStartFile($startFile) {
        $this->startFile = $startFile;
    }

    function setTargetFile($targetFile) {
        $this->targetFile = $targetFile;
    }

    function setRoot($root) {
        $this->root = $root;
    }

    function __construct($startFile, $targetFile) {
        $this->startFile = $startFile;
        $this->targetFile = $targetFile;
    }

    /**
     * Create a file with the terms in the array. The array must be in the form $node => $parent.
     * If an specific IRI is needed, it has to be change by hand.
     * @param string[] $parsed  An array $node => parents[  ]
     */
    public function write($parsed) {
        $t = file_get_contents($this->startFile);
        $lines = explode("\n", $t);
        foreach ($parsed as $node => $parents) {
            \array_push($lines, $this->buildSnipet($node, $parents));
        }
        $onto = implode("\n", $lines);
        $onto.="\n</Ontology>";
        if (\file_put_contents($this->targetFile, $onto) === false) {
            return false;
        } else {
            return $this->targetFile;
        }
    }

    /**
     * An internal function which merge some xml to create the entries for each Entity
     * @param  string $node The node.
     * @param  string $parents The parents of the node. 
     *      */
    protected function buildSnipet($node, $parents) {
        $nodeId = \str_replace(" ", "_", \strtolower($node));
        echo "node =".$node.", nodeid=".$nodeId.PHP_EOL;
        if ($parents[0] !== $this->root) {
            return " <ClassAssertion>
    <Class IRI=\"#Term\"/>
    <NamedIndividual IRI=\"#" . $nodeId . "\"/>
 </ClassAssertion> 
  <AnnotationAssertion>
    <AnnotationProperty abbreviatedIRI=\"rdfs:label\"/>
    <IRI>#" . $nodeId . "</IRI>
    <Literal xml:lang=\"en\" datatypeIRI=\"&rdf;PlainLiteral\">
    " . $node . "</Literal>
  </AnnotationAssertion>" . $this->objectPropertyAssertion($nodeId, $parents);
        } else {
            return $this->buildSnipetRoot($node);
        }
    }

//function buildSnipet

    protected function objectPropertyAssertion($nodeId, $parents) {
        $assertion = "";

        foreach ($parents as $parent) {
            $parentId = \str_replace(" ", "_", $parent);
            $assertion.="<ObjectPropertyAssertion>
    <ObjectProperty IRI=\"#wide\"/>
    <NamedIndividual IRI=\"#" . $nodeId . "\"/>
    <NamedIndividual IRI=\"#" . $parentId . "\"/>
        </ObjectPropertyAssertion> ";
        }



        return $assertion;
    }

    protected function buildSnipetRoot($node) {
        $nodeId = \str_replace(" ", "_", \strtolower($node));
        return " <ClassAssertion>
    <Class IRI=\"#Term\"/>
    <NamedIndividual IRI=\"#" . $nodeId . "\"/>
 </ClassAssertion>
 <AnnotationAssertion>
    <AnnotationProperty abbreviatedIRI=\"rdfs:label\"/>
    <IRI>#" . $nodeId . "</IRI>
    <Literal xml:lang=\"en\" datatypeIRI=\"&rdf;PlainLiteral\">
    " . $node . "</Literal>
  </AnnotationAssertion>";
    }

}
