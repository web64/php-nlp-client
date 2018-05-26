<?php

namespace Tests\Unit;

use Tests\TestCase;

class ConceptTest extends TestCase 
{
    /** @test */
    public function get_concepts_for_words()
    {
        $concept = new \Web64\Nlp\MsConceptGraph;
        $res = $concept->get('php');
        $this->msg( $res );
        $this->assertNotEmpty( $res );

        $this->assertEquals( 'language', key($res) );
        
    }

    /** @test */
    public function score_by_npmi()
    {
        $concept = new \Web64\Nlp\MsConceptGraph;
        $res = $concept->limit(3)->scoreBy('ScoreByNPMI')->smooth(0.0001)->get('php');

        $this->assertNotEmpty( $res );
        $this->assertEquals( 3, count($res) );

        $this->assertEquals( 'programming language', key($res) ); 
    }
}
