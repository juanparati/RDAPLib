<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class NameserverModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#section-5.2
 * @package Juanparati\RDAPLib\Models
 */
class NameserverModel extends BaseModel
{
    public $ldhName;
    public $unicodeName;
    public $ipAddresses;
    public $status = [];
}
