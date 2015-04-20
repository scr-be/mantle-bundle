<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Scribe\Exception\Model\ExceptionInterface;
use Scribe\Exception\Model\ExceptionTrait;

/**
 * Class AbstractHttpException.
 */
abstract class AbstractHttpException extends \Exception implements ExceptionInterface, HttpExceptionInterface
{
    use ExceptionTrait;

    /**
     * Default generic error message for base http exception.
     *
     * @var string
     */
    const MSG_HTTP_GENERAL = 'An unspecified, general HTTP error occurred.';

    /**
     * Not found default error message.
     *
     * @var string
     */
    const MSG_HTTP_NOT_FOUND = 'The requested resource "%s" could not be found.';

    /**
     * Unauthorized default error message.
     *
     * @var string
     */
    const MSG_HTTP_UNAUTHORIZED = 'You are not authorized perform the requested action.';

    /**
     * @var int|null
     */
    protected $httpStatusCode;

    /**
     * @var array|null
     */
    protected $httpHeaders;

    /**
     * Retrieve a specific HTTP status code related to the exception, if available, or simply return a an internal
     * server error status code of 500.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return (int) (is_int($this->httpStatusCode) ? $this->httpStatusCode : 500);
    }

    /**
     * Set the HTTP status code for the current request.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->httpStatusCode = (int) $statusCode;

        return $this;
    }

    /**
     * Returns an array of the HTTP headers that existed in the Request when the exception was thrown, if provided, or
     * return an empty array.
     *
     * @return array
     */
    public function getHeaders()
    {
        return (array) $this->httpHeaders;
    }

    /**
     * Set the HTTP headers for the current request.
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers = [])
    {
        $this->httpHeaders = $headers;
    }
}

/* EOF */
