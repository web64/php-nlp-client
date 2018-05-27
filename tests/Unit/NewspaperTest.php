<?php

namespace Tests\Unit;

use Tests\TestCase;

class NewspaperTest extends TestCase 
{
    /** @test */
    public function url_article_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $newspaper = $nlp->newspaper('https://github.com/web64/nlpserver');

        $this->msg( $newspaper );
        $this->assertNotEmpty($newspaper);
    }

    /** @test */
    public function html_article_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $html = file_get_contents( 'https://github.com/web64/nlpserver' );
        $newspaper = $nlp->newspaper_html( $html );
        
        $this->msg( $newspaper );

        $this->assertNotEmpty($newspaper);
        $this->assertNotEmpty($newspaper['title']);
        $this->assertNotEmpty($newspaper['text']);
    }
}
