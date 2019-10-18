<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class DomainModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-41
 * @package Juanparati\RDAPLib\Models
 */
class DomainModel extends BaseModel
{
    public $ldhName;
    public $unicodeName;
    public $variants    = [];
    public $nameservers = [];
    public $secureDNS;
    public $keyData     = [];
    public $status      = [];
    public $publicIds   = [];
    public $port43;
    public $events      = [];
    public $network     = [];

}
