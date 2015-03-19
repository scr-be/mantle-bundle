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
 * class Asset
 * @package Scribe\MantleBundle\Entity
 */
class Asset
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $embeddedCode;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var string
     */
    private $altText;

    /**
     * @var \stdClass
     */
    private $assetType;

    /**
     * @var \stdClass
     */
    private $descriptor;


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
     * Set path
     *
     * @param string $path
     * @return Asset
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set embeddedCode
     *
     * @param string $embeddedCode
     * @return Asset
     */
    public function setEmbeddedCode($embeddedCode)
    {
        $this->embeddedCode = $embeddedCode;

        return $this;
    }

    /**
     * Get embeddedCode
     *
     * @return string 
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Asset
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
     * @return Asset
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
     * Set altText
     *
     * @param string $altText
     * @return Asset
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Get altText
     *
     * @return string 
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * Set assetType
     *
     * @param \stdClass $assetType
     * @return Asset
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;

        return $this;
    }

    /**
     * Get assetType
     *
     * @return \stdClass 
     */
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * Set descriptor
     *
     * @param \stdClass $descriptor
     * @return Asset
     */
    public function setDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;

        return $this;
    }

    /**
     * Get descriptor
     *
     * @return \stdClass 
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }
}
