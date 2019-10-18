<?php


namespace Juanparati\RDAPLib\Tests;

use Juanparati\RDAPLib\ModelMapper;
use Juanparati\RDAPLib\Models\EntityModel;
use Juanparati\RDAPLib\Models\IpNetworkModel;
use Juanparati\RDAPLib\Models\LinkModel;
use Juanparati\RDAPLib\Models\NoticeModel;
use Juanparati\RDAPLib\Models\VCardArrayModel;
use Juanparati\RDAPLib\Tests\Extra\MyIpNetworkModel;

use PHPUnit\Framework\TestCase;


/**
 * Class ObjectMapperTest.
 *
 * @package Juanparati\RDAPLib\Tests
 */
class ObjectMapperTest extends TestCase
{

    /**
     * Test against IPNetwork format.
     */
    public function testIPFormat()
    {
        $data = file_get_contents(__DIR__ . '/../Resources/ip1.json');
        $data = json_decode($data, true);

        $mapper = (new ModelMapper())->getObjectMapper();
        $object = $mapper->map($data, IpNetworkModel::class);

        $this->assertTrue($object instanceof IpNetworkModel);
        $this->assertContains($object->name, 'SE-EUROPOLITAN-2008TEST');
        $this->assertCount(5, $object->entities);

        foreach ($object->entities as $entity)
        {
            $this->assertTrue($entity instanceof EntityModel);
            $this->assertObjectHasAttribute('handle', $entity);
        }

        $this->assertObjectHasAttribute('vcardArray', $object->entities[4]);
        $this->assertTrue($object->entities[4]->vcardArray->parseCard() instanceof \Sabre\VObject\Component\VCard);

        $this->assertTrue($object->entities[4]->vcardArray instanceof VCardArrayModel);
        $this->assertTrue($object->entities[4]->entities[1] instanceof EntityModel);

        $this->assertTrue($object->links[1] instanceof LinkModel);
        $this->assertStringStartsWith('<a href', $object->links[1]->asLink());

        $this->assertContains('rdap_level_0', $object->rdapConformance);

        $this->assertTrue($object->notices[2] instanceof NoticeModel);
        $this->assertTrue($object->notices[2]->title === 'Terms and Conditions');
        $this->assertTrue($object->notices[2]->links[0] instanceof LinkModel);
    }


    /**
     * Test model replacement.
     */
    public function testModelReplacement()
    {
        $data = file_get_contents(__DIR__ . '/../Resources/ip1.json');
        $data = json_decode($data, true);

        $mapper = new ModelMapper([
            'network'      => MyIpNetworkModel::class,
            'networks'     => MyIpNetworkModel::class,
        ]);

        /**
         * @var $object MyIpNetworkModel
         */
        $object = $mapper->getObjectMapper()->map($data, MyIpNetworkModel::class);

        $this->assertTrue($object instanceof MyIpNetworkModel);
        $this->assertContains('v4', $object->test());
    }
}
