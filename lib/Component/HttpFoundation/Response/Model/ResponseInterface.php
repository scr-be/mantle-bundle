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
