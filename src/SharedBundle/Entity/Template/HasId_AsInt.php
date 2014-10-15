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
