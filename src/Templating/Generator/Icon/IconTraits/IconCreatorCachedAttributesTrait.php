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

use Scribe\MantleBundle\Entity\Icon;
use Scribe\MantleBundle\Entity\IconFamily;
use Scribe\MantleBundle\Entity\IconTemplate;

/**
 * Class IconCreatorCachedAttributesTrait
 *
 * @package Scribe\MantleBundle\Templating\Generator\Icon\IconTraits
 */
trait IconCreatorCachedAttributesTrait
{
    /**
     * @var null|string
     */
    private $familySlug = null;

    /**
     * Getter for icon family slug
     *
     * @return null|string
     */
    protected function getIconFamilySlug()
    {
        return $this->familySlug;
    }

    /**
     * Setter for icon family slug
     *
     * @param  string $slug
     * @return $this
     */
    protected function setFamilySlug($slug)
    {
        $this->familySlug = $slug;

        return $this;
    }

    /**
     * Gets the value of familySlug
     *
     * @return string $familySlug
     */
    public function getFamilySlug()
    {
        return $this->familySlug;
    }

    /**
     * Checker for icon family slug
     *
     * @return bool
     */
    protected function hasFamilySlug()
    {
        return (bool) ($this->familySlug !== null);
    }

    /**
     * Reset icon family slug instance property
     *
     * @return $this
     */
    public function resetFamilySlug()
    {
        $this->familySlug = null;

        return $this;
    }
}

/* EOF */
