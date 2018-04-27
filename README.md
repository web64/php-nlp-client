# PHP NLP-Client

This is a simple PHP library for performing Natural Language tasks using the Web64 NLP-Server https://github.com/web64/nlpserver

NLP Tasks Available through Web64's NLP Server:
* Language detection
* Entity Extraction (NER) - Multilingual
* Sentiment Analysis - Multilingual
* Embeddings / Neighbouring words  - Multilingual
* Article Extraction from HTML or URL
* Summarization

NLP Tasks Available through Stanford's CoreNLP Server:
* Entity Extraction (NER)

NLP Tasks Available through Microsoft Labs API:
* Related concepts

## Installation
```bash
composer require web64/php-nlp-client
```


## Usage

### Language detection:
```php
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$detected_lang = $nlp->language( "The quick brown fox jumps over the lazy dog" );
// 'en'
```

### Article Extraction

```php
// From URL
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$newspaper = $nlp->newspaperUrl('https://github.com/web64/nlpserver');

// or from HTML
$html = file_get_contents( 'https://github.com/web64/nlpserver' );
$newspaper = $nlp->newspaperHtml( $html );

Array
(
    [article_html] => <div><h1><a id="user-content-nlp-server" class="anchor" href="#nlp-server"></a>NLP Server</h1> .... </div>
    [authors] => Array()
    [canonical_url] => https://github.com/web64/nlpserver
    [meta_data] => Array()
    [meta_description] => GitHub is where people build software. More than 27 million people use GitHub to discover, fork, and contribute to over 80 million projects.
    [meta_lang] => en
    [source_url] => ://
    [text] => NLP Server. Python Flask web service for easy access to multilingual NLP tasks such as language detection, article extraction...
    [title] => web64/nlpserver: NLP Web Service
    [top_image] => https://avatars2.githubusercontent.com/u/76733?s=400&v=4
)
```

### Entity Extraction & Sentiment Analysis
```php
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$polyglot = $nlp->polyglot( $text, 'en' );

$entities = $polyglot->getEntities();
$sentiment = $polyglot->getSentiment();
```

### Embeddings - Neighbouring words
```php
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$neighbours = $nlp->embeddings('obama', 'en');
/*
Array
(
    [0] => Bush
    [1] => Reagan
    [2] => Clinton
    [3] => Ahmadinejad
    [4] => Nixon
    [5] => Karzai
    [6] => McCain
    [7] => Biden
    [8] => Huckabee
    [9] => Lula
)
*/
```


