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

use Doctrine\ORM\Mapping as ORM;
use Scribe\SharedBundle\Entity\Template\Entity,
    Scribe\SharedBundle\Entity\Template\HasName,
    Scribe\SharedBundle\Entity\Template\HasDescription;

/**
 * Class Icon
 * @package Scribe\SharedBundle\Entity
 */
class Icon extends Entity
{
    /**
     * import name and description entity property traits
     */
    use HasName,
        HasDescription;

    /**
     * The name of the font library family (ex: "fa" for font awesome)
     * @type string
     */
    private $family;

    /**
     * @type string
     */
    private $slug;

    /**
     * @var string 
     */
    private $unicode;

    /**
     * @var jsonArray 
     */
    private $aliases;

    /**
     * @var jsonArray 
     */
    private $categories;

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
        return $this->getFamily() . ':' . $this->getName();
    }

    /**
     * Setter for family property
     * @param $family string the name of the font library
     * @return $this
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Getter for family property
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Checker for family property
     * @return bool
     */
    public function hasFamily()
    {
        return (bool) ($this->family !== null);
    }

    /**
     * Nullify family property
     * @return $this
     */
    public function clearFamily()
    {
        $this->family = null;

        return $this;
    }
}
