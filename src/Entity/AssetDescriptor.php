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
 * AssetDescriptor
 * @package Scribe\MantleBundle\Entity
 */
class AssetDescriptor
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $binContent;

    /**
     * @var string
     */
    private $markup;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $width;

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
     * Set binContent
     *
     * @param string $binContent
     * @return AssetDescriptor
     */
    public function setBinContent($binContent)
    {
        $this->binContent = $binContent;

        return $this;
    }

    /**
     * Get binContent
     *
     * @return string 
     */
    public function getBinContent()
    {
        return $this->binContent;
    }

    /**
     * Set markup
     *
     * @param string $markup
     * @return AssetDescriptor
     */
    public function setMarkup($markup)
    {
        $this->markup = $markup;

        return $this;
    }

    /**
     * Get markup
     *
     * @return string 
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return AssetDescriptor
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return AssetDescriptor
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
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
