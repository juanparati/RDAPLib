<?php


namespace Juanparati\RDAPLib;


use Juanparati\RDAPLib\Adaptors\GuzzleRequestFactory;
use Juanparati\RDAPLib\Exceptions\RDAPWrongRequest;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use RicardoFiorani\GuzzlePsr18Adapter\Client;


/**
 * Class RDAPClient.
 *
 * @package Juanparati\RDAPLib
 */
class RDAPClient
{

    /**
     * Output types.
     */
    const RAW_OUTPUT    = 3;
    const ARRAY_OUTPUT  = 2;
    const OBJECT_OUTPUT = 1;
    const MODEL_OUTPUT  = 0;


    /**
     * HTTP Client.
     *
     * @var ClientInterface
     */
    protected $httpClient;


    /**
     * HTTP Request factory.
     *
     * @var RequestFactoryInterface
     */
    protected $requestFactory;


    /**
     * Model mapper instance.
     *
     * @var ModelMapper
     */
    protected $mapper;


    /**
     * Service endpoints.
     *
     * @var array
     */
    protected $serviceCatalog =
    [
        'ip'        => 'https://rdap.db.ripe.net/ip/',
        'domain'    => 'https://rdap.verisign.com/com/v1/domain/',
        'tld'       => 'https://root.rdap.org/domain/',
        'autnum'    => 'https://rdap.db.ripe.net/autnum/',
        'entity'    => 'https://rdap.arin.net/registry/entity/',
        'registrar' => 'https://registrars.rdap.org/entity/',
    ];


    /**
     * RDAPClient constructor.
     *
     * @param array $serviceCatalog
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param ModelMapper|null $mapper
     */
    public function __construct(
        array $serviceCatalog                    = [],
        ?ClientInterface $httpClient             = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?ModelMapper $mapper                     = null
    )
    {
        $this->httpClient      = $httpClient     ?: new Client();
        $this->requestFactory  = $requestFactory ?: new GuzzleRequestFactory();
        $this->serviceCatalog  = array_merge($this->serviceCatalog, $serviceCatalog);
        $this->mapper          = $mapper ?: new ModelMapper();
    }


    /**
     * Retrieve IP information.
     *
     * @param string $ip
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function ipLookup(string $ip, int $output_type = self::MODEL_OUTPUT)
    {
        $data = $this->performRequest($this->serviceCatalog['ip'] . $ip);
        return $this->outputResult($data, $this->mapper->getClassModel('network'), $output_type);
    }


    /**
     * Retrieve Domain information.
     *
     * @param string $domain
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function domainLookup(string $domain, int $output_type = self::MODEL_OUTPUT)
    {
        $data = $this->performRequest($this->serviceCatalog['domain'] . $domain);
        return $this->outputResult($data, $this->mapper->getClassModel('domain'), $output_type);
    }


    /**
     * Retrieve TLD information.
     *
     * @param string $tld
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function tldLookup(string $tld, int $output_type = self::MODEL_OUTPUT)
    {
        $data = $this->performRequest($this->serviceCatalog['tld'] . $tld);
        return $this->outputResult($data, $this->mapper->getClassModel('domain'), $output_type);
    }


    /**
     * Retrieve Entity information.
     *
     * @param string $entity
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function entityLookup(string $entity, int $output_type = self::MODEL_OUTPUT)
    {
        $data = $this->performRequest($this->serviceCatalog['entity'] . $entity);
        return $this->outputResult($data, $this->mapper->getClassModel('entity'), $output_type);
    }


    /**
     * Retrieve registrar information.
     *
     * @param string $registrar_code
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function registrarLookup(string $registrar_code, int $output_type = self::MODEL_OUTPUT)
    {
        $registrar_code = strtoupper($registrar_code);
        $registrar_code .= substr($registrar_code, 5) === '-IANA' ? '' : '-IANA';

        $data = $this->performRequest($this->serviceCatalog['registrar'] . $registrar_code);
        return $this->outputResult($data, $this->mapper->getClassModel('entity'), $output_type);
    }

    /**
     * Retrieve Autonomous system Number.
     *
     * @param string $as
     * @param int $output_type
     * @return mixed|null
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    public function asLookup(string $autnum, int $output_type = self::MODEL_OUTPUT)
    {
        $data = $this->performRequest($this->serviceCatalog['autnum'] . $autnum);
        return $this->outputResult($data, $this->mapper->getClassModel('autnum'), $output_type);
    }


    /**
     * Output result according to the result.
     *
     * @param $data
     * @param string $model
     * @param int $outputType
     * @return mixed|null
     */
    protected function outputResult(
        $data,
        string $model,
        int $outputType
    )
    {
        if (!$data)
            return null;

        switch ($outputType)
        {
            case static::RAW_OUTPUT:
                return $data;
                break;

            case static::ARRAY_OUTPUT:
                return \GuzzleHttp\json_decode($data, true);
                break;

            case static::OBJECT_OUTPUT:
                return \GuzzleHttp\json_decode($data);
                break;
        }


        return $this->mapper->getObjectMapper()->map(\GuzzleHttp\json_decode($data, true), $model);
    }


    /**
     * Perform the low-lever request.
     *
     * @param string $url
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws RDAPWrongRequest
     */
    protected function performRequest(string $url)
    {
        $request = $this->requestFactory->createRequest('GET', $url);
        $result  = $this->httpClient->sendRequest($request);

        $status = $result->getStatusCode();

        if ($status === 404)
            return null;

        if ($status === 400)
            throw new RDAPWrongRequest('Check the TLD or IP format: ' . $url, 400);

        if (301 === $status || 302 === $status)
            return $this->performRequest($result->getHeaderLine('Location'));

        if ($status !== 200)
            throw new RDAPWrongRequest($result->getReasonPhrase(), $status);

        return $result->getBody();
    }

}
