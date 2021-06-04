<?php


namespace Juanparati\RDAPLib\Helpers;


/**
 * Class Decoder.
 *
 * @package Juanparati\RDAPLib\Helpers
 */
class Decoder
{

    /**
     * json_decode wrapper that raises and error deserialization is incomplete.
     *
     * @param string $json
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     */
    public static function json(string $json, bool $assoc = false, int $depth = 512, int $options = 0) {
        $data = \json_decode($json, $assoc, $depth, $options);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            throw new \InvalidArgumentException('json_decode error: ' . \json_last_error_msg());
        }

        return $data;
    }

}