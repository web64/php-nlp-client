<?php

namespace Tests\Unit;

use Tests\TestCase;

class NewspaperTest extends TestCase 
{
    // /** @test */
    // public function url_article_extraction()
    // {
    //     $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

    //     $newspaper = $nlp->newspaperUrl('http://www.bbc.com/news/science-environment-43710766');

    //     $this->msg( $newspaper );
    //     $this->assertNotEmpty($newspaper);
    // }

    /** @test */
    public function html_article_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $html = file_get_contents( 'http://www.bbc.com/news/science-environment-43710766' );
        $newspaper = $nlp->newspaperHtml( $html );
        
        //$this->msg( $newspaper );

        $this->assertNotEmpty($newspaper);
        $this->assertNotEmpty($newspaper['title']);
        $this->assertNotEmpty($newspaper['text']);
    }
}
