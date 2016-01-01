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
use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\HasAttributes;
use Scribe\MantleBundle\Doctrine\Base\Model\HasContent;
use Scribe\MantleBundle\Doctrine\Base\Model\HasTitle;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * Class Block.
 */
class Block extends SlugEntity
{
    use HasTitle;
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
    protected $assets;

    /**
     * @return $this
     */
    public function initializeAssets()
    {
        $this->assets = new ArrayCollection();

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @return bool
     */
    public function hasAssets()
    {
        return (bool) (!$this->assets->isEmpty());
    }
}

/* EOF */
