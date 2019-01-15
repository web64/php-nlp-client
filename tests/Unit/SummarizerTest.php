<?php

namespace Tests\Unit;

use Tests\TestCase;

class SummarizerTest extends TestCase 
{
    /** @test */
    public function get_summary()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $text = "Portland stone is a limestone from the Tithonian stage of the Jurassic period quarried on the Isle of Portland, Dorset. The quarries consist of beds of white-grey limestone 
        separated by chert beds. It has been used extensively as a building stone throughout the British Isles, notably in major public buildings in London such as St Paul's Cathedral and 
        Buckingham Palace. Portland stone is also exported to many countries—Portland stone is used in the United Nations headquarters building in New York City, for example.
        Portland stone formed in a marine environment, on the floor of a shallow, warm, sub-tropical sea probably near land (as evidenced by fossilized driftwood, which is not uncommon). 
        When seawater is warmed by the sun, its capacity to hold dissolved gas is reduced, consequently dissolved carbon dioxide (CO2) is released into the atmosphere as a gas.
         Calcium and bicarbonate ions within the water are then able to combine, to form calcium carbonate (CaCO3) as a precipitate. 
         The process of lime scale build up in a kettle in hard water areas is similar. Calcium carbonate is the principal constituent of most limestones. 
         Billions of minute crystals of precipitated calcium carbonate (called calcite) accumulated forming lime mud (called micrite) which covered the sea floor. 
         Small particles of sand or organic detritus, such as shell fragments, formed a nucleus, which became coated with layers of calcite as they were rolled around in the muddy micrite.

        The calcite gradually accumulated (by accretion) around the fragments of shell in concentric layers, forming small balls (of less than 0.5 mm diameter). 
        This process is similar to the way in which a snowball grows in size as it is rolled around in the snow. Over time, countless billions of these balls, known as \"ooids\" or \"ooliths\"
        (from the Greek for \"egg-shaped\" or \"egg-stone\"), became partially cemented together (or lithified) by more calcite, to form the oolitic limestone we now call Portland stone. 
        Fortunately, the degree of cementation in Portland stone is such that the stone is sufficiently well cemented to allow it to resist weathering, but not so well cemented that it can't be 
        readily worked (cut and carved) by masons. This is one of the reasons why Portland stone is so favoured as a monumental and architectural stone. 
        Dr Geoff Townson conducted three years doctoral research on the Portlandian, being the first to describe the patch-reef facies and Dorset-wide sedimentation details . 
        Dr Ian West of the School of Ocean and Earth Sciences at Southampton University completed a detailed geological survey of Withies Croft Quarry before the Portland Beds were quarried by 
        Albion Stone plc.
";

        $summary = $nlp->summarize( $text );

        $this->msg( $summary );

        $this->assertNotEmpty( $summary );
    }

    /** @test */
    public function get_summary_word_count()
    {
        $nlp = new \Web64\Nlp\NlpClient( $this->nlpserver_config['hosts'], $this->nlpserver_config['debug'] );

        $text = "Portland stone is a limestone from the Tithonian stage of the Jurassic period quarried on the Isle of Portland, Dorset. The quarries consist of beds of white-grey limestone 
        separated by chert beds. It has been used extensively as a building stone throughout the British Isles, notably in major public buildings in London such as St Paul's Cathedral and 
        Buckingham Palace. Portland stone is also exported to many countries—Portland stone is used in the United Nations headquarters building in New York City, for example.
        Portland stone formed in a marine environment, on the floor of a shallow, warm, sub-tropical sea probably near land (as evidenced by fossilized driftwood, which is not uncommon). 
        When seawater is warmed by the sun, its capacity to hold dissolved gas is reduced, consequently dissolved carbon dioxide (CO2) is released into the atmosphere as a gas.
         Calcium and bicarbonate ions within the water are then able to combine, to form calcium carbonate (CaCO3) as a precipitate. 
         The process of lime scale build up in a kettle in hard water areas is similar. Calcium carbonate is the principal constituent of most limestones. 
         Billions of minute crystals of precipitated calcium carbonate (called calcite) accumulated forming lime mud (called micrite) which covered the sea floor. 
         Small particles of sand or organic detritus, such as shell fragments, formed a nucleus, which became coated with layers of calcite as they were rolled around in the muddy micrite.

        The calcite gradually accumulated (by accretion) around the fragments of shell in concentric layers, forming small balls (of less than 0.5 mm diameter). 
        This process is similar to the way in which a snowball grows in size as it is rolled around in the snow. Over time, countless billions of these balls, known as \"ooids\" or \"ooliths\"
        (from the Greek for \"egg-shaped\" or \"egg-stone\"), became partially cemented together (or lithified) by more calcite, to form the oolitic limestone we now call Portland stone. 
        Fortunately, the degree of cementation in Portland stone is such that the stone is sufficiently well cemented to allow it to resist weathering, but not so well cemented that it can't be 
        readily worked (cut and carved) by masons. This is one of the reasons why Portland stone is so favoured as a monumental and architectural stone. 
        Dr Geoff Townson conducted three years doctoral research on the Portlandian, being the first to describe the patch-reef facies and Dorset-wide sedimentation details . 
        Dr Ian West of the School of Ocean and Earth Sciences at Southampton University completed a detailed geological survey of Withies Croft Quarry before the Portland Beds were quarried by 
        Albion Stone plc.
";

        $word_count = 40;
        $summary = $nlp->summarize( $text, $word_count );

        $this->msg( $summary );
        $this->msg( "Word Count: ". str_word_count($summary) );

        $this->assertNotEmpty( $summary );
        $this->assertTrue( str_word_count($summary) <= ($word_count+10) );
        $this->assertLessThanOrEqual(($word_count+10), str_word_count($summary));
    }
}
