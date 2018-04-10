<?php

require "vendor/autoload.php";

$nlpserver_config = [
    'hosts'     => [
        'http://localhost:6400/',
        'http://localhost:6400/',
    ],
    'debug'     => true,
];

$nlp = new \Web64\Nlp\NlpClient( $nlpserver_config['hosts'], $nlpserver_config['debug'] );

$newspaper = $nlp->newspaperUrl('http://www.bbc.com/news/science-environment-43710766');

print_r( $newspaper );
