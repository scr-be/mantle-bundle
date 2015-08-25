<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Asset;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * AssetDescriptor.
 */
class AssetDescriptor extends AbstractEntity
{
    /**
     * @var string
     */
    protected $binContent;

    /**
     * @var string
     */
    protected $markup;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var ArrayCollection
     */
    protected $assets;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->assets = new ArrayCollection();
    }

    /**
     * Support for casting from object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.':'.$this->getId();
    }

    /**
     * Set binContent.
     *
     * @param string $binContent
     *
     * @return AssetDescriptor
     */
    public function setBinContent($binContent)
    {
        $this->binContent = $binContent;

        return $this;
    }

    /**
     * Get binContent.
     *
     * @return string
     */
    public function getBinContent()
    {
        return $this->binContent;
    }

    /**
     * Set markup.
     *
     * @param string $markup
     *
     * @return AssetDescriptor
     */
    public function setMarkup($markup)
    {
        $this->markup = $markup;

        return $this;
    }

    /**
     * Get markup.
     *
     * @return string
     */
    public function getMarkup()
    {
        return $this->markup;
    }

    /**
     * Set height.
     *
     * @param int $height
     *
     * @return AssetDescriptor
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width.
     *
     * @param int $width
     *
     * @return AssetDescriptor
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Gets the value of assets.
     *
     * @return assets
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * Sets the value of assets.
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
