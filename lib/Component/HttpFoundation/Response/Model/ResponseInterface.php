<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation\Response\Model;

/**
 * Interface ResponseInterface.
 */
interface ResponseInterface
{
    /**
     * Last charset passed wins.
     *
     * @param string[] ...$charsets
     *
     * @return string
     */
    public function getFinalCharset(...$charsets);

    /**
     * Last status passed wins.
     *
     * @param int[] ...$statuses
     *
     * @return int
     */
    public function getFinalStatus(...$statuses);

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
     * @param string|null $content
     *
     * @return string
     */
    public function getFinalContent($content);

    /**
     * @param $content
     */
    public function setFinalContent($content);
}

/* EOF */
