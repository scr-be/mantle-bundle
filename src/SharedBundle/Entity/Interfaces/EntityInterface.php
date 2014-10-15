<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Interfaces;

/**
 * Interface EntityInterface
 * Provides the basic requirements of an Entity within the world application
 *
 * @package Scribe\SharedBundle\Entity\Interfaces
 */
interface EntityInterface
{
    /**
     * A constructor to setup any class properties
     * @return void
     */
    public function __construct();

    /**
     * Allows for casting from object to string
     *
     * @return string
     */
    public function __toString();

    /**
     * Get entity id
     *
     * @return int
     */
    public function getId();
}
