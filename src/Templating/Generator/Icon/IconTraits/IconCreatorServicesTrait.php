<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon\IconTraits;

use Scribe\MantleBundle\EntityRepository\IconFamilyRepository;

/**
 * Trait IconCreatorServicesTrait.
 */
trait IconCreatorServicesTrait
{
    /**
     * Instance of the icon family repository service.
     *
     * @var IconFamilyRepository
     */
    private $iconFamilyRepo;

    /**
     * Setter for icon family repository.
     *
     * @param IconFamilyRepository $iconFamilyRepo
     *
     * @return $this
     */
    protected function setIconFamilyRepo(IconFamilyRepository $iconFamilyRepo)
    {
        $this->iconFamilyRepo = $iconFamilyRepo;

        return $this;
    }

    /**
     * Getter for icon family repository.
     *
     * @return IconFamilyRepository
     */
    protected function getIconFamilyRepo()
    {
        return $this->iconFamilyRepo;
    }
}

/* EOF */
