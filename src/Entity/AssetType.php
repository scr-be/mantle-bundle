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

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetType
 * @package Scribe\MantleBundle\Entity
 */
class AssetType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $element;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @var ArrayCollection 
     */
    private $assets;

    /**
     * perform any entity setup
     */
    public function __construct()
    {
        $this->assets = new ArrayCollection;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set element
     *
     * @param string $element
     * @return AssetType
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element
     *
     * @return string 
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Set attributes
     *
     * @param array $attributes
     * @return AssetType
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return array 
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Gets the value of assets
     *
     * @return assets
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Sets the value of assets
     *
     * @param ArrayCollection
     *
     * @return $this
     */
    public function setAssets(ArrayCollection $assets)
    {
        $this->assets = $assets;

        return $this;
    }
}
