<?php

namespace Tests\Unit;

use Tests\TestCase;

class SentimentTest extends TestCase 
{

    /** @test */
    public function sentiment_test()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $text = "Big Ben is the largest of five bells and weighs 13.7 tonnes. It was the largest bell in the United Kingdom for 23 years. 
        The origin of the bell's nickname is open to question; it may be named after Sir Benjamin Hall, who oversaw its installation, or heavyweight boxing champion Benjamin Caunt. 
        Four quarter bells chime at 15, 30 and 45 minutes past the hour and just before Big Ben tolls on the hour. The clock uses its original Victorian mechanism, but an electric motor can be used as a backup.";
        
        $sentiment = $nlp->sentiment( $text, 'en' );
        $this->msg( "EN Sentiment:" . $sentiment );

        $sentiment = $nlp->sentiment( "This is the worst product ever" );
        $this->msg( "EN -Sentiment:" . $sentiment );

        $sentiment = $nlp->sentiment( "This is great! " );
        $this->msg( "EN +Sentiment:" . $sentiment );


        // $sentiment = $nlp->sentiment( "Detter er helt forferdelig og skrekkelig og uverdig dårlig værst uhyggelig jævlig. hater dette. ", 'no' );
        // $this->msg( "NO -Sentiment:" . $sentiment );

        // $sentiment = $nlp->sentiment( "Detter er helt fantastisk bra, det beste jeg har sett. Imponert over den gode kvaliteten. sexy, spesiell, sær, trygg, nummen, takknemmlig, tilfreds, forelsket, modig, søt, snill, hjelpsom, fantastisk, ambisjonsrik, omtenksom, macho, fin, morsom, tålmodig, familieorientert, arbeidsom, iderik, kreativ, intelligent! S", 'no' );
        // $this->msg( "NO +Sentiment:" . $sentiment );

        $this->assertNotNull( $sentiment );
    }

}