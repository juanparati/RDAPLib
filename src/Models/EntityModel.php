<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class SubEntityModel.
 *
 * Base model.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-19
 * @package Juanparati\RDAPLib\Models
 */
class EntityModel extends BaseModel
{
    public $vcardArray   = [];
    public $roles        = [];
    public $publicIds    = [];
    public $asEventActor = [];
    public $status;
    public $networks     = [];
    public $autnums      = [];
}
