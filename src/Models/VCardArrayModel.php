<?php


namespace Juanparati\RDAPLib\Models;


use Juanparati\RDAPLib\Helpers\RdapJCardParser;
use Juanparati\RDAPLib\Models\Helpers\CardModel;


/**
 * Class VCardArrayModel.
 *
 * @see https://tools.ietf.org/html/rfc7483#page-11
 * @package Juanparati\RDAPLib\Models
 */
class VCardArrayModel
{
    public $data;

    /**
     * Parse and return vCard information.
     *
     * @return CardModel
     */
    public function parseCard() : ?CardModel
    {
        return isset($this->data[1]) ? RdapJCardParser::parse($this->data[1]) : null;
    }
}
