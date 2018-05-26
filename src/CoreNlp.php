<?php

namespace Web64\Nlp;

/**
 *      wget http://nlp.stanford.edu/software/stanford-corenlp-full-2018-02-27.zip
 *      unzip stanford-corenlp-full-2018-02-27.zip
 *      cd stanford-corenlp-full-2018-02-27
 *      java -mx4g -cp "*" edu.stanford.nlp.pipeline.StanfordCoreNLPServer -port 9000 -timeout 15000
 *          -> -serverProperties StanfordCoreNLP-chinese.properties
 */
class CoreNlp
{
    public $api_url = 'http://localhost:9000/';
    public $api_hosts = [];

    public $properties = [];
    public $data;

	function __construct( $hosts, $debug = false )
	{
		$this->debug = (bool)$debug;

        if ( is_array($hosts) )
        {
			foreach( $hosts as $host )
				$this->addHost( $host );
		}
        else
            $this->addHost( $hosts );
		
		// pick random host as default
		$this->api_url = $this->api_hosts[ array_rand( $this->api_hosts ) ]; 
    }

    public function entities( $text )
    {
        $this->properties = [
            'annotators'    => 'ner',
            //'annotators'    => 'ner,sentiment',
            //'annotators'    =>'tokenize,ssplit,pos,lemma,ner,depparse,coref,quote,sentiment',
            'outputFormat'  => 'json',
        ];
        
        $this->data = $this->post_call( $text );


        $entities = [];
        
        if ( empty( $this->data['sentences']) )
            return null;

        
        foreach(  $this->data['sentences'] as $sentence )
        {
            foreach( $sentence as $key => $value )
            {
                // echo " - {$key} \n";
                // if ( $key == 'sentimentDistribution' || $key == 'sentiment' || $key == 'sentimentValue'   )
                // {
                    
                //     print_r($value);
                //     echo PHP_EOL;
                // }

                if ( $key == 'entitymentions' )
                {
                    foreach($value as $entity)
                    {
                        if ( !isset($entities[ $entity['ner'] ]) )
                            $entities[ $entity['ner'] ] = [];
                        
                        if ( array_search( $entity['text'] , $entities[ $entity['ner'] ]) === false )
                        {
                            $entities[ $entity['ner'] ][] = $entity['text'];
                        }

                    }
                    

                }
            }
            
        }
        

        return $entities;
    }

    public function post_call( $text )
    {
        $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $text,
        )
    );
    
        $url = $this->api_url;
        $url .= "?properties=" . urlencode( json_encode( $this->properties ) );

        //echo "URL: {$url} \n\n";

        $context  = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);

        //file_put_contents("corenlp.json", $result);
        
        return json_decode($result, 1);
    }
}