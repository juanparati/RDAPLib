<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class KeyDataModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-28
 * @package Juanparati\RDAPLib\Models
 */
class KeyDataModel
{
    public $flags;
    public $protocol;
    public $publicKey;
    public $algorithm;
    public $events;
    public $links;
    public $network;
}
