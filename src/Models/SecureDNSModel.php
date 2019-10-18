<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class SecureDNSModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-27
 * @package Juanparati\RDAPLib\Models
 */
class SecureDNSModel
{
    public $zoneSigned;
    public $delegationSigned;
    public $maxSigLife;
    public $dsData  = [];
    public $events  = [];
    public $links   = [];
    public $keyData = [];
}
