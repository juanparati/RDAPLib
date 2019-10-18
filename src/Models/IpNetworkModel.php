<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class IpNetworkModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-41
 * @package Juanparati\RDAPLib\Models
 */
class IpNetworkModel extends BaseModel
{
    public $startAddress;
    public $endAddress;
    public $ipVersion;
    public $name;
    public $type;
    public $country;
    public $status;
    public $parentHandle;
}
