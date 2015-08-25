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
 * class Asset.
 */
class Asset extends AbstractEntity
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $embeddedCode;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var string
     */
    protected $altText;

    /**
     * @var AssetType
     */
    protected $assetType;

    /**
     * @var AssetDescriptor
     */
    protected $assetDescriptor;

    /**
     * @var ArrayCollection
     */
    protected $containerNodeRevisions;

    /**
     * perform any entity setup.
     */
    public function __construct()
    {
        parent::__construct();

        $this->containerNodeRevisions = new ArrayCollection();
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
     * Set path.
     *
     * @param string $path
     *
     * @return Asset
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set embeddedCode.
     *
     * @param string $embeddedCode
     *
     * @return Asset
     */
    public function setEmbeddedCode($embeddedCode)
    {
        $this->embeddedCode = $embeddedCode;

        return $this;
    }

    /**
     * Get embeddedCode.
     *
     * @return string
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * Set height.
     *
     * @param int $height
     *
     * @return Asset
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
     * @return Asset
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
     * Set altText.
     *
     * @param string $altText
     *
     * @return Asset
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText.
     *
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * Set assetType.
     *
     * @param \stdClass $assetType
     *
     * @return Asset
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;

        return $this;
    }

    /**
     * Get assetType.
     *
     * @return \stdClass
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * Gets the value of assetDescriptor.
     *
     * @return $assetDescriptor
     */
    public function getAssetDescriptor()
    {
        return $this->assetDescriptor;
    }

    /**
     * Sets the value of assetDescriptor.
     *
     * @param AssetDescriptor
     *
     * @return $this
     */
    public function setAssetDescriptor(AssetDescriptor $assetDescriptor)
    {
        $this->assetDescriptor = $assetDescriptor;

        return $this;
    }

    /**
     * Gets the value of containerNodeRevisions.
     *
     * @return containerNodeRevisions
     */
    public function getContainerNodeRevisions()
    {
        return $this->containerNodeRevisions;
    }

    /**
     * Sets the value of containerNodeRevisions.
     *
     * @param ArrayCollection
     *
     * @return $this
     */
    public function setContainerNodeRevisions(ArrayCollection $containerNodeRevisions)
    {
        $this->containerNodeRevisions = $containerNodeRevisions;

        return $this;
    }
}
