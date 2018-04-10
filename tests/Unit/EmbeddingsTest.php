<?php

namespace Tests\Unit;

use Tests\TestCase;

class EmbeddingsTest extends TestCase 
{
    /** @test */
    public function get_neighbours()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config );

        $neighbours = $nlp->embeddings('obama', 'no');

        $this->msg( $neighbours );
        $this->assertNotEmpty($neighbours);
    }
}
