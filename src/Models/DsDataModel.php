<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class DSDataModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-27
 * @package Juanparati\RDAPLib\Models
 */
class DsDataModel
{
    public $keyTag;
    public $algorithm;
    public $digest;
    public $digestType;
    public $type;
    public $events = [];
    public $links  = [];
}
