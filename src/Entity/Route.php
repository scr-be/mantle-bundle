<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasName;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Model\HasParameters;

/**
 * Class Route.
 */
class Route extends AbstractEntity
{
    /*
     * import name, description, and parameters traits
     */
    use HasName,
        HasDescription,
        HasParameters;

    /**
     * A routing reference type for the Symfony routing components. Reference the constants within
     * {@see Symfony\Component\Routing\Generator\UrlGeneratorInterface} for available values.
     *
     * @var string
     */
    private $referenceType;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Setter for referenceType property.
     *
     * @param string $referenceType reference type for symfony route generator
     *
     * @return $this
     */
    public function setReferenceType($referenceType)
    {
        $this->referenceType = $referenceType;

        return $this;
    }

    /**
     * Getter for referenceType property.
     *
     * @return string
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * Checker for referenceType property.
     *
     * @return bool
     */
    public function hasReferenceType()
    {
        return (bool) ($this->referenceType !== null);
    }

    /**
     * Nullify referenceType property.
     *
     * @return $this
     */
    public function clearReferenceType()
    {
        $this->referenceType = null;

        return $this;
    }
}

/* EOF */
