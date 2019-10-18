<?php


namespace Juanparati\RDAPLib\Models;


/**
 * Class NoticeModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-10
 * @package Juanparati\RDAPLib\Models
 */
class NoticeModel
{
    public $title;
    public $description = [];
    public $links = [];
}
