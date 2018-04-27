<?php

namespace Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    public $nlpserver_config;

    public function setUp()
    {
        parent::setUp();

        $this->nlpserver_config = [
            'hosts'     => [
                'http://localhost:6400/',
                'http://localhost:6400/',
            ],
            'debug'     => false,
        ];
    }

    public function msg( $msg )
    {
        if ( is_array($msg) ||  is_object($msg) )
            $msg = print_r($msg , true);

        fwrite(STDOUT, $msg . "\n");
    }
}