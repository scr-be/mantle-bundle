<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Type;

use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasType.
 */
trait HasType
{
    /**
     * @var AbstractEntity|null
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
     * @return AbstractEntity|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AbstractEntity|null $type
     *
     * @return $this
     */
    public function setType(AbstractEntity $type = null)
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
