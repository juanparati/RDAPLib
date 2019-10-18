<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class AsEventActorModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-19
 * @package Juanparati\RDAPLib\Models
 */
class AsEventActorModel
{
    public $eventAction;
    public $eventDate;
    public $links = [];
}
