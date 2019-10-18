<?php


namespace Juanparati\RDAPLib\Exceptions;


use Throwable;


/**
 * Class RDAPWrongRequest.
 *
 * Proxy exception used when a bad request is returned code is returned.
 *
 * @package Exceptions
 */
class RDAPWrongRequest extends \Exception
{
    /**
     * RDAPWrongRequest constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
