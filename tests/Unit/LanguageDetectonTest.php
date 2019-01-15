<?php

namespace Tests\Unit;

use Tests\TestCase;

class LanguageDetectionTest extends TestCase 
//class LanguageDetectionTest extends \PHPUnit\Framework\TestCase 
{
    public $nlpserver_config;

    public function setUp()
    {
        parent::setUp();

        // $this->nlpserver_config = [
        //     'hosts'     => [
        //         'http://localhost:6400/',
        //         'http://localhost:6400/',
        //     ],
        //     'debug'     => true,
        // ];
    }

    /** @test */
    public function detect_languages()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $tests = [
            'en'    => "The quick brown fox jumps over the lazy dog",
            'pt'    => "Tirar o cavalinho da chuva.",
            'no'    => "Det er vanskelig å spå – især om fremtiden",
            'da'    => "Så er den ged barberet",
            'sv'    => "Släng dig i väggen",
            'ca'    => "Salut i força al canut",
        ];
        

        foreach( $tests as $lang => $text )
        {
            $detected_lang = $nlp->language( $text );
            $this->assertEquals($lang, $detected_lang);
        }
    }

    /** @test */
    public function single_host()
    {
        $this->nlpserver_config['hosts'] = 'http://homestead:6400/'; 

        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $detected_lang = $nlp->language( "The quick brown fox jumps over the lazy dog" );

        $this->assertEquals('en', $detected_lang);
    }


    /** @test */
    public function not_enough_text()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $detected_lang = $nlp->language( "?" );
        //$this->msg( "Detected: lang:". $detected_lang );
        $this->assertEquals('en', $detected_lang);;
    }

    /** @test */
    public function fail_first_then_retry()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );
        $nlp->api_url = 'http://localhost:6666/'; // <-- wrong port
        //print_r( $nlp );

        $detected_lang = $nlp->language( "The quick brown fox jumps over the lazy dog" );

        $this->assertEquals('en', $detected_lang);
    }

}