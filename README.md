# PHP NLP-Client

<p align="center">
    <img src="http://cdn.web64.com/nlp-norway/php-nlp.png" width="400">
</p>

This is a simple PHP library for performing multilingual Natural Language tasks using Web64's NLP-Server https://github.com/web64/nlpserver and other providers.

NLP tasks available through Web64's NLP Server:
* [Language detection](#language-detection)
* [Article Extraction from HTML or URL](#article--metadata-extraction)
* [Entity Extraction](#entitiy-extraction--sentiment-analysis-polyglot) (NER) - Multilingual
* [Sentiment Analysis](#sentiment-analysis) - Multilingual
* [Embeddings / Neighbouring words](#neighbouring-words-embeddings) - Multilingual
* [Summarization](#summarization)

NLP Tasks Available through Stanford's CoreNLP Server:
* [Entity Extraction (NER)](#corenlp---entity-extraction-ner)

NLP Tasks Available through Microsoft Labs API:
* [Concept Graph](#concept-graph)

### Laravel Package
There is also a Laravel wrapper for this library available here: https://github.com/web64/laravel-nlp

## Installation
```bash
composer require web64/php-nlp-client
```

## NLP Server
Most NLP features in this package requires a running instance of the NLP Server, which is a simple python flask app providing web service api access to common python NLP libraries.

Installation instrcuctions: https://github.com/web64/nlpserver

## Entity Extraction - Named Entity Recognition (NER)
This library provides access to three different methods for entity extraction.

| Provider  | Language Support | Programming Lang. | API Access |
| ------------- | ------------- | ------------- | ------------- |
| [Polyglot](https://polyglot.readthedocs.io/en/latest/)  | 40 languages  | Python | NLP Server |
| [Spacy](https://spacy.io/)  | 7 languages | Python | NLP Server |
| [CoreNLP](https://stanfordnlp.github.io/CoreNLP/download.html)  | 6 languages  | Java | CoreNLP Standalone server |

If you are dealing with text in English or one of the major European language you will get the best results with CoreNLP or Spacy.

The quality of extracted entities with Polyglot is not great, but for many languages it is the only available option at the moment.

Polyglot and Spacy NER is accessible thorough the NLP Server, CoreNLP requires its own standalone java server.

## Usage

### Language detection:

```php
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$detected_lang = $nlp->language( "The quick brown fox jumps over the lazy dog" );
// 'en'
```

### Article & Metadata Extraction

```php
// From URL
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$newspaper = $nlp->newspaper('https://github.com/web64/nlpserver');

// or from HTML
$html = file_get_contents( 'https://github.com/web64/nlpserver' );
$newspaper = $nlp->newspaper_html( $html );

Array
(
    [article_html] => <div><h1><a id="user-content-nlp-server" class="anchor" href="#nlp-server"></a>NLP Server</h1> .... </div>
    [authors] => Array()
    [canonical_url] => https://github.com/web64/nlpserver
    [meta_data] => Array()
    [meta_description] => GitHub is where people build software. More than 27 million people use GitHub to discover, fork, and contribute to over 80 million projects.
    [meta_lang] => en
    [source_url] => 
    [text] => NLP Server. Python Flask web service for easy access to multilingual NLP tasks such as language detection, article extraction...
    [title] => web64/nlpserver: NLP Web Service
    [top_image] => https://avatars2.githubusercontent.com/u/76733?s=400&v=4
)
```


### Entitiy Extraction & Sentiment Analysis (Polyglot)
This uses the Polyglot multilingual NLP library to return entities and a sentiment score for given text.Ensure the models for the required languages are downloaded for Polyglot.

```php
$polyglot = $nlp->polyglot_entities( $text, 'en' );

$polyglot->getSentiment(); // -1

$polyglot->getEntityTypes(); 
/*
Array
(
    [Locations] => Array
    (
        [0] => United Kingdom
    )
    [Organizations] =>
    [Persons] => Array
    (
        [0] => Ben
        [1] => Sir Benjamin Hall
        [2] => Benjamin Caunt
    )
)
*/

$polyglot->getLocations();  // Array of Locations
$polyglot->getOrganizations(); // Array of organisations
$polyglot->getPersons(); // Array of people

$polyglot->getEntities();
/*                                              
Returns flat array of all entities
Array                                          
(                                              
    [0] => Ben                                 
    [1] => United Kingdom                      
    [2] => Sir Benjamin Hall                   
    [3] => Benjamin Caunt                      
)
*/
```



### Entity Extraction with Spacy
```php
$text = "Harvesters is a 1905 oil painting on canvas by the Danish artist Anna Ancher, a member of the artists' community known as the Skagen Painters.";

$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$entities = $nlp->spacy_entities( $text );
/*
Array
(
    [DATE] => Array
        (
            [0] => 1905
        )

    [NORP] => Array
        (
            [0] => Danish
        )

    [ORG] => Array
        (
            [0] => the Skagen Painters
        )

    [PERSON] => Array
        (
            [0] => Anna Ancher
        )
)
*/
```

English is used by default. To use another language,  ensure the Spacy language model is downloaded and add the language as the second parameter
```php
$entities = $nlp->spacy_entities( $spanish_text, 'es' );
```

### Sentiment Analysis

```php
$sentiment = $nlp->sentiment( "This is the worst product ever" );
// -1

$sentiment = $nlp->sentiment( "This is great! " );
// 1

// specify language in second parameter for non-english
$sentiment = $nlp->sentiment( $french_text, 'fr' );
```

### Neighbouring words (Embeddings)
```php
$nlp = new \Web64\Nlp\NlpClient('http://localhost:6400/');
$neighbours = $nlp->neighbours('obama', 'en');
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

### Summarization
Extract short summary from a long text
```php
$summary = $nlp->summarize( $long_text );
```


### Readability
Article Extraction using python port of Readability.js

```php
$nlp = new \Web64\Nlp\NlpClient( 'http://localhost:6400/' );

// From URL:
$article = $nlp->readability('https://github.com/web64/nlpserver');

// From HTML:
$html = file_get_contents( 'https://github.com/web64/nlpserver' );
$article = $nlp->readability_html( $html );

/*
Array
(
    [article_html] => <div><h1>NLP Server</h1><p>Python 3 Flask web service for easy access to multilingual NLP tasks ...
    [short_title] => web64/nlpserver: NLP Web Service
    [text] => NLP Server Python 3 Flask web service for easy access to multilingual NLP tasks such as language detection  ...
    [title] => GitHub - web64/nlpserver: NLP Web Service
)
*/
```

## CoreNLP - Entity Extraction (NER) 
CoreNLP has much better quality for NER that Polyglot, but only supports a few languages including English, French, German and Spanish.

Download CoreNLP server (Java) here: https://stanfordnlp.github.io/CoreNLP/index.html#download

### Install CoreNLP
```bash
# Update download links with latest versions from the download page

wget http://nlp.stanford.edu/software/stanford-corenlp-full-2018-10-05.zip
unzip stanford-corenlp-full-2018-10-05.zip
cd stanford-corenlp-full-2018-02-27

# Download English language model:
wget http://nlp.stanford.edu/software/stanford-english-kbp-corenlp-2018-10-05-models.jar
```

### Running the CoreNLP server
```bash
# Run the server using all jars in the current directory (e.g., the CoreNLP home directory)
java -mx4g -cp "*" edu.stanford.nlp.pipeline.StanfordCoreNLPServer -port 9000 -timeout 15000

# To run server in as a background process
nohup java -mx4g -cp "*" edu.stanford.nlp.pipeline.StanfordCoreNLPServer -port 9000 -timeout 15000 &
```
When the CoreNLP server is running you can access it on port 9000: http://localhost:9000/

More info about running the CoreNLP Server: https://stanfordnlp.github.io/CoreNLP/corenlp-server.html

```php
$corenlp = new \Web64\Nlp\CoreNlp('http://localhost:9000/');
$entities = $corenlp->entities( $text );
/*
Array
(
    [NATIONALITY] => Array
        (
            [0] => German
            [1] => Turkish
        )
    [ORGANIZATION] => Array
        (
            [0] => Foreign Ministry
        )
    [TITLE] => Array
        (
            [0] => reporter
            [1] => journalist
            [2] => correspondent
        )
    [COUNTRY] => Array
        (
            [0] => Turkey
            [1] => Germany
        )
*/

```

## Concept Graph
Microsoft Concept Graph For Short Text Understanding: https://concept.research.microsoft.com/

Find related concepts to provided keyword
```php
$concept = new \Web64\Nlp\MsConceptGraph;
$res = $concept->get('php');
/*
Array
(
    [language] => 0.40301612064483
    [technology] => 0.19656786271451
    [programming language] => 0.14456578263131
    [open source technology] => 0.057202288091524
    [scripting language] => 0.049921996879875
    [server side language] => 0.044201768070723
    [web technology] => 0.031201248049922
    [server-side language] => 0.027561102444098
    [server side scripting language] => 0.023920956838274
    [feature] => 0.021840873634945
)
*/
```


## Python libraries
These are the python libraries used by the NLP Server for the NLP and data extraction tasks.

| Library | URL | NLP Task used |
| ------------- | ------------- | ------------- | 
| langid.py | https://github.com/saffsd/langid.py | Language detection |  
| Newspaper | https://github.com/codelucas/newspaper | Article & metadata extraction |
| Spacy | https://spacy.io/ | Entity extraction |
| Polyglot  | https://github.com/aboSamoor/polyglot | Multilingual NLPprocessing toolkit |
| Gensim | https://radimrehurek.com/gensim/ | Summarization |
| Readability | https://github.com/buriy/python-readability | Article extraction |


## Other PHP NLP projects

* https://github.com/patrickschur/language-detection
* http://php-nlp-tools.com/


## Contribute
Get in touch if you have any feedback or ideas on how to improve this package or the documentation.

