<?php


namespace Juanparati\RDAPLib\Tests\Extra;

use Juanparati\RDAPLib\Models\IpNetworkModel;


/**
 * Class MyIpNetworkModel.
 *
 * Test class used for test the model replacement.
 *
 * @package Juanparati\RDAPLib\Tests\Extra
 */
class MyIpNetworkModel extends IpNetworkModel
{
    /**
     * New method.
     *
     * @return mixed
     */
    public function test()
    {
        return $this->ipVersion;
    }
}
