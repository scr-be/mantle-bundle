<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Subscriber;

use Doctrine\Common\EventSubscriber;

/**
 * Class SubscriberInterface.
 */
interface SubscriberInterface extends EventSubscriber
{
    /**
     * Return an array of events to subscribe to.
     *
     * @return string[]
     */
    public function getSubscribedEvents();
}

/* EOF */
