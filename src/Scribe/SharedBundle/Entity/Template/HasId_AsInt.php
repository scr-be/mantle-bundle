<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Class HasId_AsInt
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasId_AsInt
{
    /**
     * The id property
     *
     * @var integer
     */
    protected $id;

    /**
     * Getter for id property
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
