<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\HttpFoundation\Exception\Model;

use Scribe\Wonka\Exception\ExceptionInterface;

/**
 * Interface HttpExceptionInterface.
 */
interface HttpExceptionInterface extends ExceptionInterface
{
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
     * Default generic error code for http exceptions.
     *
     * @var int
     */
    const CODE_HTTP_GENERAL = 400;

    /**
     * Not found error code for http exceptions.
     *
     * @var int
     */
    const CODE_HTTP_NOT_FOUND = 404;

    /**
     * Unauthorized error code for http exceptions.
     *
     * @var int
     */
    const CODE_HTTP_UNAUTHORIZED = 401;

    /**
     * @param int|null $code
     *
     * @return $this
     */
    public function setStatusCode($code);

    /**
     * @return int|null
     */
    public function getStatusCode();

    /**
     * @return bool
     */
    public function hasStatusCode();

    /**
     * @param array|null $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers = []);

    /**
     * @return array|null
     */
    public function getHeaders();

    /**
     * @return bool
     */
    public function hasHeaders();
}

/* EOF */
