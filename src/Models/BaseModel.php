<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class BaseModel.
 *
 * Base model.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-19
 * @package Juanparati\RDAPLib\Models
 */
abstract class BaseModel
{
    public $objectClassName;
    public $handle;
    public $entities    = [];
    public $links       = [];
    public $remarks     = [];
    public $events      = [];
    public $notices     = [];
    public $port43;
}
