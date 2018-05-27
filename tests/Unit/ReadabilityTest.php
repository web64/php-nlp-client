<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReadabilityTest extends TestCase 
{
    /** @test */
    public function readability_url_article_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $article = $nlp->readability('https://github.com/web64/nlpserver');

        //$this->msg( $article );
        $this->assertNotEmpty($article);
    }

    /** @test */
    public function readability_html_article_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $html = file_get_contents( 'https://github.com/web64/nlpserver' );
        $article = $nlp->readability_html( $html );
        
        $this->msg( $article );

        $this->assertNotEmpty($article);
        $this->assertNotEmpty($article['title']);
        $this->assertNotEmpty($article['short_title']);
        $this->assertNotEmpty($article['article_html']);
        $this->assertNotEmpty($article['text']);
    }
}