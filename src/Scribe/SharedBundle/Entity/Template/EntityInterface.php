<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Interface EntityInterface
 * @package Scribe\SharedBundle\Entity\Template
 */
interface EntityInterface
{
    /**
     * Should have a constructor to setup entity properties
     * @return void
     */
    public function __construct();

    /**
     * Support casting from object type to string type
     *
     * @return string
     */
    public function __toString();

    /**
     * Support standardized and extended output when object instance
     * is passed to {@see var_dump()}
     *
     * @return array
     */
    public function __debugInfo();

    /**
     * Get entity id
     *
     * @return int|null
     */
    public function getId();
}
