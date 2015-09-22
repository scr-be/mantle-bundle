<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class Response.
 */
trait ResponseTrait
{
    /**
     * Get the headers bag.
     *
     * @return ResponseHeaderBag
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Add a header (overwriting if already exists).
     *
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->headers->add([$key => $value]);

        return $this;
    }

    /**
     * Check for header key.
     *
     * @return bool
     */
    public function hasHeader($key)
    {
        return (bool) $this->headers->has($key);
    }

    /**
     * Clear a header key.
     *
     * @param string $key
     *
     * @return $this
     */
    public function clearHeader($key)
    {
        $this->headers->remove($key);

        return $this;
    }

    /**
     * Clear entire header bag.
     *
     * @return $this
     */
    public function clearHeaderCollection()
    {
        foreach ($this->headers->keys() as $key) {
            $this->headers->remove($key);
        }

        return $this;
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

        return is_float($p) ? $p : $this->getFinalProtocol(...$protocols);
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
        $headerCount = count($headerCollections);
        $finalHeaders = [];

        for ($i = 0; $i < $headerCount; $i++) {
            if (count($headerCollections) === 0) {
                continue;
            }

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
            if (!array_key_exists('key', $newHeader) && !array_key_exists('value', $newHeader)) {
                continue;
            }

            $final[trim($newHeader['key'])] = trim($newHeader['value']);
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
