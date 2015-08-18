<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Translation;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasSlug;
use Scribe\Doctrine\Base\Model\HasValue;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * Class Translation;
 */
class Translation extends AbstractEntity
{
    use HasSlug;
    use HasValue;
    use TimestampableBehaviorTrait;

    /**
     * @var bool
     */
    protected $dynamic;

    protected $locale;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getSlug();
    }

    /**
     * Define the values that should be serialized for this entity.
     *
     * @return $this
     */
    public function initializeSerializable()
    {
        $this->setSerializablePropertyCollection('id', 'slug', 'content', 'dynamic');

        return $this;
    }

    /**
     * Define the default value for dynamic property.
     *
     * @return $this
     */
    public function initializeDynamic()
    {
        $this->dynamic = false;

        return $this;
    }
}

/* EOF */
