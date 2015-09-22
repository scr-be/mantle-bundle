<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Description;

/**
 * Class DescriptionInterface.
 */
interface DescriptionInterface
{
    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription($description = null);

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return bool
     */
    public function hasDescription();

    /**
     * @return $this
     */
    public function clearDescription();
}

/* EOF */
