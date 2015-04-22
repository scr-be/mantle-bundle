<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation\Exception\Model;

/**
 * Trait HttpExceptionTrait.
 */
trait HttpExceptionTrait
{
    /**
     * @return int
     */
    abstract public function getStatusCode();

    /**
     * @param int|null $code
     *
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = (int) $code;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasStatusCode()
    {
        return (bool) ($this->getStatusCode() !== null ?: false);
    }

    /**
     * @return array
     */
    abstract public function getHeaders();

    /**
     * @param array|null $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers = [])
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasHeaders()
    {
        return (bool) (empty($this->getHeaders()) !== true ?: false);
    }
}

/* EOF */
