<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

/**
 * Class HasId_AsInt
 *
 * @package Scribe\MantleBundle\Entity\Template
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

/* EOF */
