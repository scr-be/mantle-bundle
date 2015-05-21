<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\InstantMessenger;

use Scribe\Doctrine\Base\Model\Type\TypeInterface;
use Scribe\Doctrine\Base\Model\Name\NameInterface;

/**
 * Class InstantMessengerInterface.
 */
interface InstantMessengerInterface extends TypeInterface, NameInterface
{
    /**
     * @param string $instantMessenger
     *
     * @deprecated
     *
     * @return $this
     */
    public function setIM($instantMessenger);

    /**
     * @return string|null
     *
     * @deprecated
     */
    public function getIM();

    /**
     * @param string $instantMessenger
     *
     * @return $this
     */
    public function setInstantMessenger($instantMessenger);

    /**
     * @return string|null
     */
    public function getInstantMessenger();
}

/* EOF */
