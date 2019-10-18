<?php


namespace Juanparati\RDAPLib\Models;


use Sabre\VObject;

/**
 * Class RemarkModel.
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
     * @return VObject\Document
     */
    public function parseCard()
    {
        return VObject\Reader::readJson($this->data);
    }
}
