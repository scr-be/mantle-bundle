<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Type;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class TypeInterface.
 */
interface TypeInterface
{
    /**
     * @return AbstractEntity|null
     */
    public function getType();

    /**
     * @param AbstractEntity|null $type
     *
     * @return $this
     */
    public function setType(AbstractEntity $type = null);

    /**
     * @return bool
     */
    public function hasType();

    /**
     * @return $this
     */
    public function clearType();
}

/* EOF */
