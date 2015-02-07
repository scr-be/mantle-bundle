<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionAwareTrait
 *
 * @package Scribe\SharedBundle\DependencyInjection\Traits
 */
trait SessionAwareTrait
{
    /**
     * Session property
     *
     * @var SessionInterface|null
     */
    protected $session = null;

    /**
     * Setter for session property from container
     *
     * @param ContainerInterface $container container object
     * @return $this
     */
    public function setSessionFromContainer(ContainerInterface $container)
    {
        $this->setSession($container->get('request')->getSession());

        return $this;
    }

    /**
     * Setter for session
     *
     * @param  SessionInterface $session session instance
     * @return $this
     */
    public function setSession(SessionInterface $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Getter for session
     *
     * @return SessionInterface|null
     */
    public function getSession()
    {
        return $this->session;
    }
}
