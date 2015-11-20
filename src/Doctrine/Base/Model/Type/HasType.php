<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Type;

use Scribe\Doctrine\ORM\Mapping\Entity;

/**
 * Class HasType.
 */
trait HasType
{
    /**
     * @var Entity|null
     */
    protected $type;

    /**
     * Initialize trait.
     */
    public function initializeType()
    {
        $this->type = null;
    }

    /**
     * @return Entity|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Entity|null $type
     *
     * @return $this
     */
    public function setType(Entity $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasType()
    {
        return (bool) ($this->type !== null);
    }

    /**
     * @return $this
     */
    public function clearType()
    {
        $this->type = null;

        return $this;
    }
}

/* EOF */
