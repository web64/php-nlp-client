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

$neighbours = $nlp->embeddings('obama', 'no');

print_r( $neighbours );
