<?php


namespace Juanparati\RDAPLib\Tests;

use Juanparati\RDAPLib\Models\AutnumModel;
use Juanparati\RDAPLib\Models\DomainModel;
use Juanparati\RDAPLib\Models\EntityModel;
use Juanparati\RDAPLib\Models\IpNetworkModel;
use Juanparati\RDAPLib\RDAPClient;
use PHPUnit\Framework\TestCase;


/**
 * Class RequestTest.
 *
 * @package Juanparati\RDAPLib\Tests
 */
class RequestTest extends TestCase
{


    /**
     * RDAPClient used for all tests.
     *
     * @var RDAPClient
     */
    protected static RDAPClient $client;


    /**
     * @Fixture
     */
    public static function setUpBeforeClass() : void
    {
        static::$client = new RDAPClient();
    }


    /**
     * Test ipLookup.
     *
     * @package Juanparati\RDAPLib\Test
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testIpLookup()
    {
        $data = static::$client->ipLookup('187.105.156.58');

        $this->assertTrue($data instanceof IpNetworkModel);
    }


    /**
     * Test ipLookup.
     *
     * @package Juanparati\RDAPLib\Test
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testDomainLookup()
    {
        $data = static::$client->domainLookup('google.com');

        $this->assertTrue($data instanceof DomainModel);
    }


    /**
     * Test tldLookup.
     *
     * @package Juanparati\RDAPLib\Test
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testTldLookup()
    {
        $data = static::$client->tldLookup('com');

        $this->assertTrue($data instanceof DomainModel);
    }


    /**
     * Test asLookup.
     *
     * @package Juanparati\RDAPLib\Test
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testAsLookup()
    {
        $data = static::$client->asLookup(1);

        $this->assertTrue($data instanceof AutnumModel);
    }


    /**
     * Test entityLookup.
     *
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testEntityLookup()
    {
        $data = static::$client->entityLookup('APL7-ARIN');

        $this->assertTrue($data instanceof EntityModel);
        $this->assertContains($data->objectClassName, ['entity']);
    }


    /**
     * Test entityLookup.
     *
     * @throws \Juanparati\RDAPLib\Exceptions\RDAPWrongRequest
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function testRegistrarLookup()
    {
        $data = static::$client->registrarLookup(1);

        $this->assertTrue($data instanceof EntityModel);
        $this->assertContains($data->objectClassName, ['entity']);
    }
}
