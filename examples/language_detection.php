<?php

require "vendor/autoload.php";

$nlpserver_config = [
    'hosts'     => [
        'http://localhost:6400/',
        'http://localhost:6400/',
    ],
    'debug'     => false,
];

$nlp = new \Web64\Nlp\NlpClient( $nlpserver_config['hosts'], $nlpserver_config['debug'] );

$texts = [
    'en'    => "The quick brown fox jumps over the lazy dog",
    'pt'    => "Tirar o cavalinho da chuva.",
    'no'    => "Det er vanskelig å spå – især om fremtiden",
    'da'    => "Så er den ged barberet",
    'sv'    => "Släng dig i väggen",
    'ca'    => "Salut i força al canut",
];

foreach( $texts as $lang => $text)
{
    echo "\nTEXT: $text \n";
    $detected_language = $nlp->language( $text );
    echo " -> detected language: {$detected_language} - [actual: {$lang}]\n";

}
