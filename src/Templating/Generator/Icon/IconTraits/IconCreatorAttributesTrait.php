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
 * Class IconCreatorAttributesTrait
 *
 * @package Scribe\MantleBundle\Templating\Generator\Icon\IconTraits
 */
trait IconCreatorAttributesTrait
{
    /**
     * @var null|IconFamily
     */
    private $familyEntity = null;

    /**
     * @var null|Icon
     */
    private $iconEntity = null;

    /**
     * @var null|string
     */
    protected $iconSlug = null;

    /**
     * @var null|IconTemplate
     */
    private $templateEntity = null;

    /**
     * @var null|string
     */
    protected $templateSlug = null;

    /**
     * @var array
     */
    protected $optionalStyles = [];

    /**
     * Getter for icon family entity
     *
     * @return null|IconFamily
     */
    protected function getFamilyEntity()
    {
        return $this->familyEntity;
    }

    /**
     * Setter for icon family entity
     *
     * @param  IconFamily|null $family
     * @return $this
     */
    protected function setFamilyEntity(IconFamily $family = null)
    {
        $this->familyEntity = $family;

        return $this;
    }

    /**
     * Checker for icon family entity
     *
     * @return bool
     */
    protected function hasFamilyEntity()
    {
        return (bool) ($this->familyEntity instanceof IconFamily);
    }

    /**
     * Reset icon family instance property
     *
     * @return $this
     */
    public function resetFamilyEntity()
    {
        $this->familyEntity = null;

        return $this;
    }

    /**
     * Getter for icon entity
     *
     * @return null|Icon
     */
    protected function getIconEntity()
    {
        return $this->iconEntity;
    }

    /**
     * Setter for icon entity
     *
     * @param  Icon $icon
     * @return $this
     */
    protected function setIconEntity(Icon $icon)
    {
        $this->iconEntity = $icon;

        return $this;
    }

    /**
     * Checker for icon entity
     *
     * @return bool
     */
    protected function hasIconEntity()
    {
        return (bool) ($this->iconEntity instanceof Icon);
    }

    /**
     * Reset icon entity instance property
     *
     * @return $this
     */
    public function resetIconEntity()
    {
        $this->iconEntity = null;

        return $this;
    }

    /**
     * Getter for icon slug
     *
     * @return null|string
     */
    protected function getIconSlug()
    {
        return $this->iconSlug;
    }

    /**
     * Setter for icon slug
     *
     * @param  string $slug
     * @return $this
     */
    protected function setIconSlug($slug)
    {
        $this->iconSlug = $slug;

        return $this;
    }

    /**
     * Checker for icon slug
     *
     * @return bool
     */
    protected function hasIconSlug()
    {
        return (bool) ($this->iconSlug !== null);
    }

    /**
     * Reset icon slug instance property
     *
     * @return $this
     */
    public function resetIconSlug()
    {
        $this->iconSlug = null;

        return $this;
    }

    /**
     * Getter for icon template entity
     *
     * @return null|IconTemplate
     */
    protected function getTemplateEntity()
    {
        return $this->templateEntity;
    }

    /**
     * Setter for icon template entity
     *
     * @param  IconTemplate $template
     * @return $this
     */
    protected function setTemplateEntity(IconTemplate $template)
    {
        $this->templateEntity = $template;

        return $this;
    }

    /**
     * Checker for icon template entity
     *
     * @return bool
     */
    protected function hasTemplateEntity()
    {
        return (bool) ($this->templateEntity instanceof IconTemplate);
    }

    /**
     * Reset icon template entity instance property
     *
     * @return $this
     */
    public function resetTemplateEntity()
    {
        $this->templateEntity = null;

        return $this;
    }

    /*
     * Getter for icon template slug
     *
     * @return null|string
     */
    protected function getTemplateSlug()
    {
        return $this->templateSlug;
    }

    /**
     * Setter for icon template slug
     *
     * @param  null|string $slug
     * @return $this
     */
    protected function setTemplateSlug($slug = null)
    {
        $this->templateSlug = $slug;

        return $this;
    }

    /**
     * Checker for icon template slug
     *
     * @return bool
     */
    protected function hasTemplateSlug()
    {
        return (bool) ($this->templateSlug !== null);
    }

    /**
     * Reset icon template slug instance property
     *
     * @return $this
     */
    public function resetTemplateSlug()
    {
        $this->templateSlug = null;

        return $this;
    }

    /**
     * Getter for additional styles
     *
     * @return array
     */
    protected function getOptionalStyles()
    {
        return $this->optionalStyles;
    }

    /**
     * Setter for additional styles
     *
     * @param  string[] $styles
     * @return $this
     */
    protected function setOptionalStyles(...$styles)
    {
        $this->optionalStyles = (array) $styles;

        return $this;
    }

    /**
     * Check if additional styles have been requested
     *
     * @return bool
     */
    protected function hasOptionalStyles()
    {
        return (bool) (count($this->optionalStyles) > 0);
    }

    /**
     * Reset icon styles instance property
     *
     * @return $this
     */
    public function resetOptionalStyles()
    {
        $this->optionalStyles = [];

        return $this;
    }
}

/* EOF */
