<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Aware;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class SessionAwareTrait.
 */
trait SessionAwareTrait
{
    /**
     * Session property.
     *
     * @var Session|null
     */
    protected $session = null;

    /**
     * Setter for session property from container.
     *
     * @param ContainerInterface $container container object
     *
     * @return $this
     */
    public function setSessionFromContainer(ContainerInterface $container)
    {
        $this->setSession($container->get('request')->getSession());

        return $this;
    }

    /**
     * Setter for session.
     *
     * @param Session $session
     *
     * @return $this
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Getter for session.
     *
     * @return Session|null
     */
    public function getSession()
    {
        return $this->session;
    }
}

/* EOF */
