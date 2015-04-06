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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasAttributes;

/**
 * AssetType.
 */
class AssetType extends AbstractEntity
{
    /*
     * import traits
     */
    use HasAttributes;

    /**
     * @var string
     */
    private $element;

    /**
     * @var ArrayCollection
     */
    private $assets;

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
     * Set element.
     *
     * @param string $element
     *
     * @return AssetType
     */
    public function setElement($element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Get element.
     *
     * @return string
     */
    public function getElement()
    {
        return $this->element;
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
