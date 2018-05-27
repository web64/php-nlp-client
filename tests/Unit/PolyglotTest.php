<?php

namespace Tests\Unit;

use Tests\TestCase;

class PolyglotTest extends TestCase 
{

    /** @test */
    public function entity_extraction()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $text = "Big Ben is the largest of five bells and weighs 13.7 tonnes. It was the largest bell in the United Kingdom for 23 years. 
        The origin of the bell's nickname is open to question; it may be named after Sir Benjamin Hall, who oversaw its installation, or heavyweight boxing champion Benjamin Caunt. 
        Four quarter bells chime at 15, 30 and 45 minutes past the hour and just before Big Ben tolls on the hour. The clock uses its original Victorian mechanism, but an electric motor can be used as a backup.";
        
        $polyglot = $nlp->polyglot_entities( $text, 'en' );

        $this->msg( $polyglot );
        $this->msg(  $polyglot->getEntities() );

        $this->assertNotEmpty( $polyglot->data );
        $this->assertArrayHasKey('sentiment', $polyglot->data, "Missing sentiment");
        $this->assertNotEmpty( $polyglot->data['entities'] );

        $this->assertNotEmpty( 
            $polyglot->getEntities()
        );

        $this->assertNotEmpty( 
            $polyglot->getPersons()
         );
         

        $this->assertTrue(
            is_numeric($polyglot->getSentiment())
        );

        $this->assertCount(
            3,
            $polyglot->getEntityTypes()
        );
        
        
    }

}