<?php

namespace Tests\Unit;

use Tests\TestCase;

class SpacyEntitiesTest extends TestCase 
{
    /** @test */
    public function get_summary()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $text = "D. B. Cooper is a media epithet popularly used to refer to an unidentified man who hijacked a Boeing 727 aircraft in the airspace between Portland, Oregon, and Seattle, Washington, on November 24, 1971. He extorted $200,000 in ransom (equivalent to $1,210,000 in 2017) and parachuted to an uncertain fate. Despite an extensive manhunt and protracted FBI investigation, the perpetrator has never been located or identified. The case remains the only unsolved air piracy in commercial aviation history.";

        $text = "Harvesters is a 1905 oil painting on canvas by the Danish artist Anna Ancher, a member of the artists' community known as the Skagen Painters.";
        $entities = $nlp->spacy_entities( $text );

        $this->msg( $entities );

        $this->assertNotEmpty( $entities );
        $this->assertNotEmpty( $entities['PERSON'] );
        $this->assertNotEmpty( $entities['ORG'] );
    }
}