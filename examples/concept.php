<?php

require "vendor/autoload.php";

$concept = new \Web64\Nlp\MsConceptGraph;
$concept->debug = true;

$res = $concept->get('php');
print_r( $res );

echo "\nGet Score by NPMI:\n";
$res = $concept->limit(3)->scoreBy('ScoreByNPMI')->smooth(0.0001)->get('php');
print_r( $res );