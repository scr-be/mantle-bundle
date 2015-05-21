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
     * @param mixed|null  $content              The response content {@see setFinalContent()}
     * @param int|null    $status               Status for this response.
     * @param array       $headers              Headers specific to this response.
     * @param array       $headersGlobal        The global headers configured.
     * @param array       $headersTypeSpecific  The type-specific headers configured.
     * @param string|null $charsetGlobal        The global charset configured.
     * @param string|null $charsetTypeSpecific  The type-specific charset configured.
     * @param float|null  $protocolGlobal       The global charset configured.
     * @param float|null  $protocolTypeSpecific The type-specific charset configured.
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @api
     */
    public function __construct($content = null, $status = null, $headers = [],
                                $headersGlobal = [], $headersTypeSpecific = [],
                                $charsetGlobal = null, $charsetTypeSpecific = null,
                                $protocolGlobal = null, $protocolTypeSpecific = null)
    {
        parent::__construct(
            $this->getFinalContent($content),
            $this->getFinalStatus($status),
            $this->getFinalHeaders($headersGlobal, $headersTypeSpecific, $headers)
        );

        $this->setCharset($this->getFinalCharset($charsetGlobal, $charsetTypeSpecific));
        $this->setProtocolVersion($this->getFinalProtocol($protocolGlobal, $protocolTypeSpecific));
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return (array) $this->headers;
    }

    /**
     * @param $content
     */
    public function setFinalContent($content)
    {
        $this->content = $this->getFinalContent($content);
    }

    /**
     * @param string|null $content
     *
     * @return string
     */
    public function getFinalContent($content)
    {
        if (true === is_scalar($content)) {
            return (string) $content;
        }

        return (string) '';
    }

    /**
     * Last status passed wins.
     *
     * @param int[] ...$statuses
     *
     * @return int
     */
    public function getFinalStatus(...$statuses)
    {
        if (count($statuses) === 0) {
            return $this->getDefaultStatus();
        }

        $s = array_pop($statuses);

        return is_int($s) ? $s : $this->getFinalStatus(...$statuses);
    }

    /**
     * Last charset passed wins.
     *
     * @param string[] ...$charsets
     *
     * @return string
     */
    public function getFinalCharset(...$charsets)
    {
        if (count($charsets) === 0) {
            return $this->getDefaultCharset();
        }

        $c = array_pop($charsets);

        return is_scalar($c) ? $c : $this->getFinalCharset(...$charsets);
    }

    /**
     * Last protocol passed wins.
     *
     * @param float[] ...$protocols
     *
     * @return float
     */
    public function getFinalProtocol(...$protocols)
    {
        if (count($protocols) === 0) {
            return $this->getDefaultProtocol();
        }

        $p = array_pop($protocols);

        return is_float($p) ? $p : $this->getFinalCharset(...$protocols);
    }

    /**
     * All passed headers are merged. If header arrays have conflicting keys
     * last passed key wins.
     *
     * @param array $headerCollections
     *
     * @return array
     */
    public function getFinalHeaders(array ...$headerCollections)
    {
        $finalHeaders = [];

        for ($i = 0; $i < count($headerCollections); $i++) {
            $this->getFinalHeadersMerged($finalHeaders, $headerCollections[$i]);
        }

        return $finalHeaders;
    }

    /**
     * Merge current final headers with each collection of headers.
     *
     * @param array $final Passed by referenced.
     * @param array $new   Additions (overwrites) to current final headers.
     *
     * @return $this
     */
    protected function getFinalHeadersMerged(array &$final, array $new)
    {
        foreach ($new as $newHeader) {
            $headerParts = explode(':', $newHeader);
            if (count($headerParts) !== 2) {
                continue;
            }

            $final[trim($headerParts[0])] = trim($headerParts[1]);
        }

        return $this;
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
