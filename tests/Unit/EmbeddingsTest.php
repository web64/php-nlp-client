<?php

namespace Tests\Unit;

use Tests\TestCase;

class EmbeddingsTest extends TestCase 
{
    /** @test */
    public function get_neighbours()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );
        
        $neighbours = $nlp->neighbours('obama', 'no');

        // $this->msg( $neighbours );

        $this->assertNotEmpty($neighbours);
    }
}
