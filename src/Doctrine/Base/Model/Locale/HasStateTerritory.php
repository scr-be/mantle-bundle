<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Locale;

use Scribe\MantleBundle\Doctrine\Entity\Locale\StateTerritory;

/**
 * Class HasStateTerritory.
 */
trait HasStateTerritory
{
    /**
     * @var StateTerritory
     */
    protected $stateTerritory;

    /**
     * @return $this
     */
    public function initializeStateTerritory()
    {
        $this->stateTerritory = null;

        return $this;
    }

    /**
     * @param StateTerritory $stateTerritory
     *
     * @return $this
     */
    public function setStateTerritory(StateTerritory $stateTerritory)
    {
        $this->stateTerritory = $stateTerritory;

        return $this;
    }

    /**
     * @return StateTerritory
     */
    public function getStateTerritory()
    {
        return $this->stateTerritory;
    }

    /**
     * @return bool
     */
    public function hasStateTerritory()
    {
        return (bool) ($this->stateTerritory !== null);
    }

    /**
     * @return $this
     */
    public function clearStateTerritory()
    {
        return $this->initializeStateTerritory();
    }
}

/* EOF */
