<?php

namespace Web64\Nlp;

/**
 * Microsoft Concept Graph For Short Text Understanding
 *   - Documentation: https://concept.research.microsoft.com/
 *   - Example: https://concept.research.microsoft.com/api/Concept/ScoreByProb?instance=laravel&topK=10&smooth=1
 */
class MsConceptGraph
{
    private $api_url = "https://concept.research.microsoft.com/api/Concept/";
    private $limit = 10;
    private $smooth = 0.0001;
    private $score_by = 'ScoreByProb';
    public $debug = false;

    public function limit( $limit )
    {
        $this->limit = (int)$limit;

        return $this;
    }

    public function scoreBy( $score_by )
    {
        $this->score_by = $score_by;
        return $this;
    }

    public function smooth( $smooth )
    {
        $this->smooth = $smooth;
        return $this;
    }

    public function get( $word )
    {
        $url = $this->api_url . $this->score_by . "?instance=" . urlencode($word) . "&topK=". $this->limit . "&smooth=". $this->smooth;

        return $this->call( $url );
    }

    public function getNpmi( $word )
    {
        return $this->scoreBy('ScoreByNPMI')->get( $url );
    }

    public function call( $url )
    {
        if ( $this->debug ) echo "URL: $url \n";

        $context_params = array(
            'http' => array(
                    'method' => 'GET',
                    'header' => "Content-Type: application/json\r\n",
                ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        
        $context = stream_context_create( $context_params );
        $response = file_get_contents($url, FALSE, $context);
        return json_decode($response, 1);  
    }
}