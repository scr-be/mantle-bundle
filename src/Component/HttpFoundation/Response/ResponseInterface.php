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
 * Interface ResponseInterface.
 */
interface ResponseInterface
{
    /**
     * Get the headers bag.
     *
     * @api
     *
     * @return ResponseHeaderBag
     */
    public function getHeaders();

    /**
     * Add a header (overwriting if already exists).
     *
     * @param string $key
     * @param string $value
     *
     * @api
     *
     * @return $this
     */
    public function addHeader($key, $value);

    /**
     * Check for header key.
     *
     * @api
     *
     * @return bool
     */
    public function hasHeader($key);

    /**
     * Clear a header key.
     *
     * @param string $key
     *
     * @api
     *
     * @return $this
     */
    public function clearHeader($key);

    /**
     * Sets the response status code.
     *
     * @param int   $code HTTP status code
     * @param mixed $text HTTP status text
     *
     * If the status text is null it will be automatically populated for the known
     * status codes and left empty otherwise.
     *
     * @return $this
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     *
     * @api
     */
    public function setStatusCode($code, $text = null);

    /**
     * @param mixed $content
     *
     * @return $this
     *
     * @throws \UnexpectedValueException
     *
     * @api
     */
    public function setContent($content);

    /**
     * Clear entire header bag.
     *
     * @api
     *
     * @return $this
     */
    public function clearHeaderCollection();

    /**
     * @param $content
     *
     * @api
     */
    public function setFinalContent($content);

    /**
     * @param string|null $content
     *
     * @return string
     */
    public function getFinalContent($content);

    /**
     * Last status passed wins.
     *
     * @param int[] ...$statuses
     *
     * @return int
     */
    public function getFinalStatus(...$statuses);

    /**
     * Last charset passed wins.
     *
     * @param string[] ...$charsets
     *
     * @return string
     */
    public function getFinalCharset(...$charsets);

    /**
     * Last protocol passed wins.
     *
     * @param float[] ...$protocols
     *
     * @return float
     */
    public function getFinalProtocol(...$protocols);

    /**
     * All passed headers are merged. If header arrays have conflicting keys
     * last passed key wins.
     *
     * @param array $headerCollections
     *
     * @return array
     */
    public function getFinalHeaders(array ...$headerCollections);

    /**
     * @return string
     */
    public function getDefaultCharset();

    /**
     * @return int
     */
    public function getDefaultStatus();

    /**
     * @return float
     */
    public function getDefaultProtocol();

    /**
     * @return array
     */
    public function getDefaultHeaders();
}

/* EOF */
