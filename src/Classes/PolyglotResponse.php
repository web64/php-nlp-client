<?php

namespace Web64\Nlp\Classes;

/**
 *  Polyglot response object for entities (NER) and sentiment analysis results.
 */
class PolyglotResponse
{
	public $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->process();
    }

    public function process()
    {
        $entites_clean = array();
		if ( !empty($this->data['entities']) )
		{
			foreach($this->data['entities'] as $words)
			{
                $entity = $this->getEntityFromWords( $words );
                
				if ( isset($entites_clean[$entity]) )
					$entites_clean[$entity]++;
				else
					$entites_clean[$entity] = 1;
			}
		}
		
		if ( !empty($this->data['type_entities']) )
		{
			$tmp_a = array();
			foreach($this->data['type_entities'] as $ent)
			{
				foreach($ent as $type => $words)
				{
					$entity = $this->getEntityFromWords( $words );
					
					if ( isset($tmp_a[$type][$entity]) )
						$tmp_a[$type][$entity]++;
					else
						$tmp_a[$type][$entity] = 1;
				}
			}
			$this->data['type_entities'] = $tmp_a;
		}
		
		arsort($entites_clean);
		
        $this->data['entities'] = $entites_clean;
        
    }

    public function getEntityFromWords( $words )
    {
        // if first word is '.' -> remove
        if ( $words[0] == '.' )
            array_shift( $words );

        // if last word is '.' -> remove last element and add '.' to previous element
        if ( count( $words ) > 1 &&  $words[ count($words)-1 ]  == '.')
        {
            array_pop($words);
            $words[ count($words)-1 ] .= '.';
        }
        
        $entity = implode(' ', $words);
        $entity = str_replace(' - ', '-', $entity); // John Doe - Ohlsen -> John Doe-Ohlsen
        $entity = str_replace(' . ', ' ', $entity); // "U.S . troops" -> "U.S. troops"

        return trim( $entity );
    }

    public function getSentiment()
    {
        return ( isset( $this->data['sentiment'] ) ) ? $this->data['sentiment'] : null;
    }

    public function getEntities()
    {
        return array_keys( $this->data['entities'] );
    }

    public function getEntityTypes()
    {
        return [
            'Locations'     => $this->getLocations(),
            'Organizations' => $this->getOrganizations(),
            'Persons'       => $this->getPersons(),
        ];
    }

    public function getLocations()
    {
        if ( !empty($this->data['type_entities']['I-LOC']) )
            return array_keys( $this->data['type_entities']['I-LOC'] );
    }

    public function getOrganizations()
    {
        if ( !empty($this->data['type_entities']['I-ORG']) )
            return array_keys( $this->data['type_entities']['I-ORG'] );
    }

    public function getPersons()
    {
        if ( !empty($this->data['type_entities']['I-PER']) )
            return array_keys( $this->data['type_entities']['I-PER'] );
    }
    
}