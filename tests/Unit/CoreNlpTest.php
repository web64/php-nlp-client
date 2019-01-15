<?php

namespace Tests\Unit;

use Tests\TestCase;
/**
 *      java -mx4g -cp "*" edu.stanford.nlp.pipeline.StanfordCoreNLPServer -port 9000 -timeout 15000
 *      nohup java -mx4g -cp "*" edu.stanford.nlp.pipeline.StanfordCoreNLPServer -port 9000 -timeout 15000 &
 */
class CoreNlpTest extends TestCase 
{
    /** @test */
    public function test_core_nlp()
    {
        $corenlp = new \Web64\Nlp\CoreNlp('http://homestead:9000/');

        //echo PHP_EOL. PHP_EOL;
        $text = "Catalonia: Ex-police chief Trapero charged with sedition. The former chief of Catalonia's police force, Josep Lluis Trapero, has been charged over events linked with last year's independence referendum.";

        $text = "German Foreign Ministry investigating arrest of German reporter in Turkey.
        Germany's Foreign Ministry has said it is investigating claims that a German journalist has been detained in Turkey. Adil Demirci is believed to have been arrested while on vacation in Istanbul.
        The German Foreign Ministry said on Friday that it was responding to reports that Adil Demirci, a journalist for the left-leaning Turkish news agency Etha, had been detained in Istanbul, although the reasons for his arrest remained unclear.
        The detention of another journalist after the release of Deniz Yücel would be another obstacle in already frayed German-Turkish relations.
        What we know about Adil Demirci's arrest so far

    Reports suggested that Demirci was one of three Etha reporters detained during a series of police raids in Istanbul overnight on Thursday.
    The German Foreign Ministry said it was \"working on the basis that Adil Demirci has been arrested,\" but admitted Turkish authorities had yet to confirm such reports.
    Demirci reportedly worked as a Germany correspondent for Etha and lived in the city of Cologn.
    News of Demirci's arrest was first reported by Mesale Tolu, a colleague of his at Etha. Tolu herself was one of several German nationals arrested in Turkey year last year for political reasons. Tolu tweeted on Friday morning that Demirci was detained with two colleagues, Pınar Gayip and Semiha Sahin, during a raid. Demirci, who reportedly holds both German and Turkish citizenship, was in Istanbul on holiday, Tolu said. Reports suggested he was scheduled to fly back to Germany on Saturday. 
    ";
        //echo $text . PHP_EOL. PHP_EOL;
        $entities = $corenlp->entities( $text );
        $this->msg( $entities );
        
        //var_dump($entities);
        //exit;

        $this->assertNotEmpty( $entities['COUNTRY'] );
        $this->assertNotEmpty( $entities['NATIONALITY'] );
    }
}
