<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class AutnumModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#section-5.5
 * @package Juanparati\RDAPLib\Models
 */
class AutnumModel extends BaseModel
{
   public $startAutnum;
   public $endAutnum;
   public $name;
   public $type;
   public $status;
   public $country;
}
