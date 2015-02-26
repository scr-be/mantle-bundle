<?php
/*
 * This file is part of scribe-foundation-bundle.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator\Icon;

use Scribe\SharedBundle\EntityRepository\IconFamilyRepository;

/**
 * Trait IconRepositoryTrait
 *
 * @package Scribe\SharedBundle\Templating\Generator\Icon
 */
trait IconRepositoryTrait
{
    /**
     * Instance of the icon family repository service
     *
     * @var IconFamilyRepository
     */
    private $iconFamilyRepo;

    /**
     * Setter for icon family repository
     *
     * @param  IconFamilyRepository $iconFamilyRepo
     * @return $this
     */
    protected function setIconFamilyRepo(IconFamilyRepository $iconFamilyRepo)
    {
        $this->iconFamilyRepo = $iconFamilyRepo;

        return $this;
    }

    /**
     * Getter for icon family repository
     *
     * @return IconFamilyRepository
     */
    protected function getIconFamilyRepo()
    {
        return $this->iconFamilyRepo;
    }
}

/* EOF */
