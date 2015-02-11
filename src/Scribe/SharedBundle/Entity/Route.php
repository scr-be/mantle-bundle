<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity;

use Scribe\SharedBundle\Entity\Template\Entity;
use Scribe\SharedBundle\Entity\Template\HasName;
use Scribe\SharedBundle\Entity\Template\HasDescription;
use Scribe\SharedBundle\Entity\Template\HasParameters;

/**
 * Class Route
 * @package Scribe\SharedBundle\Entity
 */
class Route extends Entity
{
    /**
     * import name, description, and parameters traits
     */
    use HasName,
        HasDescription,
        HasParameters;

    /**
     * A routing reference type for the Symfony routing components. Reference the constants within
     * {@see Symfony\Component\Routing\Generator\UrlGeneratorInterface} for available values.
     * @type string
     */
    private $referenceType;

    /**
     * perform any entity setup
     */
    public function __construct() {}

    /**
     * Support for casting from object type to string type
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Setter for referenceType property
     * @param string $referenceType reference type for symfony route generator
     * @return $this
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * Getter for referenceType property
     * @return string
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * Checker for referenceType property
     * @return bool
     */
    public function hasReferenceType()
    {
        return (bool) ($this->referenceType !== null);
    }

    /**
     * Nullify referenceType property
     * @return $this
     */
    public function clearReferenceType()
    {
        $this->referenceType = null;

        return $this;
    }
}
