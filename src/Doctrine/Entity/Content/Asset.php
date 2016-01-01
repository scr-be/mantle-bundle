<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Content;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\ORM\Mapping\UuidEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAttributes;
use Scribe\MantleBundle\Doctrine\Base\Model\HasContent;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * Class Asset.
 */
class Asset extends UuidEntity
{
    use HasName;
    use HasDescription;
    use HasContent;
    use HasAttributes;
    use TimestampableBehaviorTrait;

    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var ArrayCollection
     */
    protected $blocks;

    /**
     * @return $this
     */
    public function initializeBlocks()
    {
        $this->blocks = new ArrayCollection();

        return $this;
    }

    /**
     * @param ArrayCollection $blocks
     *
     * @return $this
     */
    public function setBlocks(ArrayCollection $blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @return bool
     */
    public function hasBlocks()
    {
        return (bool) (!$this->blocks->isEmpty());
    }

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function hasBlock(Block $block)
    {
        return (bool) ($this->blocks->contains($block));
    }

    /**
     * @param Block $block
     *
     * @return $this
     */
    public function addBlock(Block $block)
    {
        if (!$this->hasBlock($block)) {
            $this->blocks->add($block);
        }

        return $this;
    }

    /**
     * @param Block $block
     *
     * @return $this
     */
    public function removeBlock(Block $block)
    {
        $this->blocks->removeElement($block);

        return $this;
    }
}

/* EOF */
