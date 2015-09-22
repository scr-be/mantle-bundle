<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\InstantMessenger;

/**
 * Class HasInstantMessenger.
 */
trait HasInstantMessenger
{
    /**
     * @var string|null
     */
    protected $instantMessenger;

    /**
     * Initialize trait.
     */
    public function initializeInstantMessenger()
    {
        $this->instantMessenger = null;
    }

    /**
     * @param string $instantMessenger
     *
     * @deprecated
     *
     * @return $this
     */
    public function setIM($instantMessenger)
    {
        return $this->setInstantMessenger($instantMessenger);
    }

    /**
     * @return string|null
     *
     * @deprecated
     */
    public function getIM()
    {
        return $this->getInstantMessenger();
    }

    /**
     * @param string $instantMessenger
     *
     * @return $this
     */
    public function setInstantMessenger($instantMessenger)
    {
        $this->instantMessenger = $instantMessenger;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstantMessenger()
    {
        return $this->instantMessenger;
    }
}

/* EOF */
