<?php

namespace Tests\Unit;

use Tests\TestCase;

class AfinnTest extends TestCase 
{
    /** @test */
    public function get_neighbours()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );
        
        $text = "This is great fantastic stuff!";
        $score = $nlp->afinn_sentiment( $text, 'en');

        $this->msg( "{$text}\nSCORE: {$score}" );
        $this->assertGreaterThan(0, $score, "Positive text not greater than zero");



        $text = "This is horrible and aweful disgusting bad crap!";
        $score = $nlp->afinn_sentiment( $text, 'en');

        $this->msg( "{$text}\nSCORE: {$score}" );
        $this->assertLessThan(0, $score, "Negative text not less than zero");
    }
}
