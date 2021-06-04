![](https://api.travis-ci.com/juanparati/RDAPLib.svg?branch=master)

# RDAPLib

Branch 1.0 is compatible with Guzzle 6.x.

[Branch 2.0](https://github.com/juanparati/RDAPLib/tree/2.0) is compatible with Guzzle 7.x.

## About

RDAPLib is a Registration Data Access Protocol (RDAP) client library that query and resolve results into models, arrays or standard objects (stdObject).

This library uses [Guzzle](http://docs.guzzlephp.org/en/stable/) as default http client, however is possible to inject any custom HTTP client that is compliant with [PSR-18](https://www.php-fig.org/psr/psr-18/). 


## Usage

### Basic example

    $rdap = new \Juanparati\RDAPLib\RDAPClient();
    
    $ip        = $rdap->ipLookup('94.234.38.5');    
    $domain    = $rdap->domainLookup('google.com');
    $tld       = $rdap->tldLookup('io');
    $entity    = $rdap->entityLookup('APL7-ARIN')
    $as        = $rdap->asLookup(1);
    $registrar = $rdap->registrarLookup(1);


### Output formats

RDAPClient map the result into models, however is possible to return the results using the following types:

- RAW_OUTPUT (JSON string)
- ARRAY_OUTPUT (Nested array)
- OBJECT_OUTPUT (stdClass)
- MODEL_OUTPUT

The "lookups" method accept a secondary parameter where to specify the format.

Example:

     $rdap = new \Juanparati\RDAPLib\RDAPClient();
        
     $ip     = $rdap->ipLookup('94.234.38.5', \Juanparati\RDAPLib\RDAPClient\RAW_OUTPUT);    
     $domain = $rdap->domainLookup('google.com', \Juanparati\RDAPLib\RDAPClient\ARRAY_OUTPUT);
     $tld    = $rdap->tldLookup('io', \Juanparati\RDAPLib\RDAPClient\OBJECT_OUTPUT);
     $entity = $rdap->entityLookup('APL7-ARIN')   // Default output is MODEL_OUTPUT
    

### Model format

The model format is suitable when data accessors or extra parameters are required. RDAPClient provides defaults models that are possible to replace.
The models are based on [RFC-7483](https://tools.ietf.org/html/rfc7483).

For example the default method for "vcardArray" provides a method that can parse jCard format.

Example:

    $rdap = new \Juanparati\RDAPLib\RDAPClient();
    
    $domain = $rdap->domainLookup('google.com');
    $contact = $rdap->entities[0]->vcardArray->parseCard();
    
The link model has another method that can generate HTML links:

 $rdap = new \Juanparati\RDAPLib\RDAPClient();
    
    $domain = $rdap->domainLookup('google.com');
    echo $rdap->links[0]->asLink();
 
It's possible to replace the current models with your own custom models. In order achieve that a custom ModelMapper is required.

Example:

    // 1. Define our custom model that extends the default one.
    class MyIpAddressModel extends \Juanparati\RDAPLib\Models\IpAddressModel {
        
        /**
         * Our new method
         */
        public function getFirstIpV4Ip() : ?string {
            return $this->v4[0] ?? null;
        }
    }

    // 2. Instantiate a custom mapper with the model replacement.   
    $mapper = new \Juanparati\RDAPLib\ModelMapper([         
        'ipAddresses'  => \Juanparati\RDAPLib\Models\IpAddressModel::class,            
    ]);
    
    // 3. Instantiate the client injecting our custom mapper
    $rdap = new \Juanparati\RDAPLib\RDAPClient([], null, null, $mapper);
    

### Use different endpoints

By default RDAPLib uses the following endpoints according to the lookup type:

    'ip'        => 'https://rdap.db.ripe.net/ip/',
    'domain'    => 'https://rdap.org/domain/',
    'tld'       => 'https://root.rdap.org/domain/',
    'autnum'    => 'https://rdap.db.ripe.net/autnum/',
    'entity'    => 'https://rdap.arin.net/registry/entity/',
    'registrar' => 'https://registrars.rdap.org/entity/',
    
 It's possible to replace the endpoints passing a new ones into the first parameter of the RDAPClient constructor.
 
 Example:
 
    $rdap = new \Juanparati\RDAPLib\RDAPClient(['ip' => 'https://rdap.org/ip/']);


### Use a custom HTTP Client

RDAPLib allows to inject a custom [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP Client.
The client will also require a message interface [PSR-7](https://www.php-fig.org/psr/psr-7/).

Example:

     $rdap = new \Juanparati\RDAPLib\RDAPClient(
        [],
        $myCompatiblePSR18HTTPClient,
        $myCompatiblePSR7MessageInterface
     );


## Supporters
- [superkredit.net](https://superkredit.net/)
- [fair-laan.se](https://fair-laan.se/)
- [fair-laan.dk](https://fair-laan.dk/)
- [matchbanker.fi](https://matchbanker.fi/)
- [mamuph.org](http://mamuph.org)
