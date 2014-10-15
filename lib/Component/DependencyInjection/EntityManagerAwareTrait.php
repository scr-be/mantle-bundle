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
use Doctrine\ORM\EntityManager;

/**
 * Class EntityManagerAwareTrait
 *
 * @package Scribe\SharedBundle\DependencyInjection
 */
trait EntityManagerAwareTrait
{
    /**
     * Instance of entity manager
     *
     * @var EntityManager|null
     */
    protected $em = null;

    /**
     * Setter for entity manager property from container
     *
     * @param ContainerInterface $container container object
     */
    public function setEntityManagerFromContainer(ContainerInterface $container)
    {
        $this->setEntityManager($container->get('doctrine.orm.default_entity_manager'));
    }

    /**
     * Setter for entity manager
     *
     * @param  EntityManager|null $em entity manager instance
     * @return $this
     */
    public function setEntityManager(EntityManager $em = null)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * Getter for entity manager
     *
     * @return EntityManager|null
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Convenience getter for entity manager {@see getEntityManager}
     *
     * @return EntityManager|null
     */
    public function getEm()
    {
        return $this->getEntityManager();
    }
}
