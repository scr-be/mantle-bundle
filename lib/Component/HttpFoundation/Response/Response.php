<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Scribe\Component\HttpFoundation\Response\Model\ResponseInterface;

/**
 * Class Response.
 */
class Response extends SymfonyResponse implements ResponseInterface
{
    /**
     * Construct the basic instance properties.
     *
     * @param mixed $content The response content {@see setContent()}
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @api
     */
    public function __construct($content = null, $status = null, array $headers = [])
    {
        parent::__construct(
            $this->getFinalContent($content),
            $this->getFinalStatus($status),
            $this->getFinalHeaders($headers)
        );
    }

    /**
     * @param string|null $content
     *
     * @return string
     */
    protected function getFinalContent($content)
    {
        if (true === is_scalar($content)) {
            return (string) $content;
        }

        return (string) '';
    }

    /**
     * @param int|null $status
     *
     * @return int
     */
    protected function getFinalStatus($status)
    {
        if (true === is_int($status)) {
            return (int) $status;
        }

        return $this->getDefaultStatus();
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    protected function getFinalHeaders(array $headers)
    {
        return $headers;
    }

    /**
     * @returen int
     */
    public function geDefaultStatus()
    {
        return 200;
    }

    /**
     * @return string
     */
    public function getDefaultCharset()
    {
        return 'utf-8';
    }

    /**
     * @return int
     */
    public function getDefaultStatus()
    {
        return 200;
    }

    /**
     * @return float
     */
    public function getDefaultProtocol()
    {
        return 1.1;
    }

    /**
     * @return array
     */
    public function getDefaultHeaders()
    {
        return [];
    }
}

/* EOF */
