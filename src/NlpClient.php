<?php

namespace Web64\Nlp;

/**
 * 		Simple interface to the Web64 NLP-Server (https://github.com/web64/nlpserver) for Natural Language Processing tasks
 */

class NlpClient{
	
	public $api_url;
    public $api_hosts = [];
    public $fail_count = 0;
    public $debug = false;
    private $max_retry_count = 3;
	
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
	
	/**
	 * 	Spacy.io Entity Extraction
	 */
	public function spacy_entities( $text, $lang = 'en' )
	{
		$data =  $this->post_call('/spacy/entities', ['text' => $text, 'lang' => $lang ] );

		return ( !empty($data['entities']) ) ? $data['entities'] : null;
	}

	/**
	 * 	AFINN Sentiment Analysis
	 */
	public function afinn_sentiment( $text, $lang = 'en' )
	{
		$data =  $this->post_call('/afinn', ['text' => $text, 'lang' => $lang ] );

		return ( isset($data['afinn']) ) ? $data['afinn'] : null;
	}

	/**
	 * 	Summarize long text
	 */
	public function summarize( $text, $word_count = null )
	{
		$data =  $this->post_call('/gensim/summarize', ['text' => $text, 'word_count' => $word_count ] );
		
		return ( !empty($data['summarize']) ) ? $data['summarize'] : null;
	}

	/**
	 * 	Article Extraction from HTML
	 */
	public function newspaper_html( $html )
	{
		$data =  $this->post_call('/newspaper', ['html' => $html ] );
		
		return ( !empty($data['newspaper']) ) ? $data['newspaper'] : null;
	}

	/**
	 * 	Article Extraction from URL
	 */
	public function newspaper( $url )
	{
		$data = $this->get_call('/newspaper', ['url' => $url ] );

		return ( !empty($data['newspaper']) ) ? $data['newspaper'] : null;
	}

	
	/**
	 * 	Readability Article Extraction from URL
	 */
	public function readability( $url )
	{
		$data = $this->get_call('/readability', ['url' => $url ] );

		return ( !empty($data['readability']) ) ? $data['readability'] : null;
	}

	/**
	 * 	Readability Article Extraction from HTML
	 */
	public function readability_html( $html )
	{
		$data = $this->post_call('/readability', ['html' => $html ] );

		return ( !empty($data['readability']) ) ? $data['readability'] : null;
	}

	/**
	 * 	Sentiment Analysis by Polyglot
	 */
	public function sentiment( $text, $language = null )
	{
		$data = $this->post_call('/polyglot/sentiment', ['text' => $text, 'lang' => $language ] );

		return ( isset($data['sentiment']) ) ? $data['sentiment'] : null;
	}

	/**
	 * 		Get neighbouring words
	 */
	public function neighbours( $word, $lang = 'en')
	{
		$data = $this->get_call('/polyglot/neighbours', ['word' => $word, 'lang' => $lang ] );

		return ( !empty($data['neighbours']) ) ? $data['neighbours'] : null;
	}

	/**
	 * 	Get entities and sentiment analysis of text
	 */
	public function polyglot_entities( $text, $language = null )
	{
		$data = $this->post_call('/polyglot/entities', ['text' => $text, 'lang' => $language] );
		$this->msg( $data );
		return new \Web64\Nlp\Classes\PolyglotResponse( $data['polyglot'] );
	}

	/**
	 * 		Get language code for text
	 */
	public function language( $text )
	{
		$data = $this->post_call('/langid', ['text' => $text] );

		if ( isset($data['langid']) && isset($data['langid']['language']))
		{
			// return 'no' for Norwegian Bokmaal and Nynorsk
			if ( $data['langid']['language'] == 'nn' || $data['langid']['language'] == 'nb' )
				return 'no';

			return $data['langid']['language'];
		}
		
		return null;
    }

    public function post_call($path, $params, $retry = 0 )
    {
		$url = $this->api_url . $path;
		$this->msg( "NLP API $path - $url ");
		$retry++;
		
		if ( $retry > $this->max_retry_count )
		{
			return null;
		}

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => http_build_query( $params ),
		    )
		);
		
		$context  = stream_context_create($opts);
		$result = @file_get_contents($url, false, $context);

		if ( empty($result) || ( isset($http_response_header) && $http_response_header[0] != 'HTTP/1.0 200 OK' ) ) // empty if server is down
		{
			$this->msg( "Host Failed: {$url}" );

			if ( $retry >= $this->max_retry_count )
				return null;

			$this->chooseHost();
			return $this->post_call($path, $params, $retry );
		}

		if ( empty($result) ) return null;

		return json_decode($result, 1);
	}
	
	public function get_call($path, $params, $retry = 0)
	{
		$url = $this->api_url . $path;
		
		$retry++;
		
		if ( !empty($params) )
			$url  .= '?' . http_build_query( $params );

		$this->msg( "NLP API [GET] $path - $url ");
		$result = @file_get_contents( $url, false );

		if ( empty($http_response_header) || $http_response_header[0] == 'HTTP/1.0 404 NOT FOUND' )
			return null;

		if ( empty($result) || ( isset($http_response_header) && $http_response_header[0] != 'HTTP/1.0 200 OK' ) ) // empty if server is down
		{
			$this->msg( "Host Failed: {$url}" );

			if ( $retry >= $this->max_retry_count )
				return null;

			$this->chooseHost();
			return $this->get_call($path, $params, $retry );
		}

		if ( empty($result) ) return null;

		return  json_decode($result, 1);

	}

	/**
	 * 	Internals
	 */
    public function addHost( $host )
    {
		$host = rtrim( $host , '/');

        if (  array_search($host, $this->api_hosts) === false)
            $this->api_hosts[] = $host;
    }
    
    // debug message
    private function msg( $value )
    {
        if ( $this->debug )
        {
            if ( is_array($value) )
            {
				if(!defined('STDOUT'))
				{
					print_r( $value );
				}else{
					fwrite(STDOUT, print_r( $value, true ) . PHP_EOL );
				}
            }
			else
			{
				if(!defined('STDOUT')){
					echo $value . PHP_EOL;
				}else{
					fwrite(STDOUT, $value . PHP_EOL );
				}
			}
        }
    }

	// find working host
	private function chooseHost()
	{
		$random_a = $this->api_hosts;
		shuffle($random_a); // pick random host
		
		foreach( $random_a as $api_url )
		{
            $this->msg( "chooseHost() - Testing: $api_url ");
            
			$content = @file_get_contents( $api_url );
			if ( empty( $content ) )
			{

                $this->msg( $content );
				// Failed
                $this->msg( "- Ignoring failed API URL: $api_url " );
				//print_r( $http_response_header );
			}else{
				$this->api_url = $api_url;
				$this->msg( "- Working API URL: $api_url" );
				return true;
				 
			}
            $this->msg( $content );
		}
		
		return false;
	}

}
