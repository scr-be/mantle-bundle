<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Component\Template;

use Scribe\SharedBundle\Component\Exceptions\IconFormatterException;

/**
 * Class HasCode
 *
 * @package Scribe\SharedBundle\Component\Template
 */
trait IconAttributes
{
    private $family = null;

    private $icon = null;

    private $iconSlug = null;

    private $template = null;

    private $styles = null;

    public function getFamily()
    {
        return $this->family;
    }

    public function setFamily($familySlug)
    {
        $family = $this->getIconFamilyBySlug($familySlug);
        $this->family = $family;

        return $this;
    }

    public function hasFamily()
    {
        return (bool) ($this->family !== null);
    }

    public function clearFamily()
    {
        $this->family = null;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    /*
     * This actually sets the iconSlug variable; the icon 
     * is checked and set upon rendering
     */
    public function setIcon($iconSlug)
    {
        $this->iconSlug = $iconSlug;

        return $this;
    }

    /*
     * Sets icon entity when render function is called
     */
    private function setIconEntity()
    {
        $iconSlug = $this->filterIconSlug($this->iconSlug);
        try {
            $icon = $this->iconRepo->loadIconByFamilyAndSlug($this->getFamily(), $iconSlug);
            $this->icon = $icon;
        }
        catch(\Exception $e) {
            throw new IconFormatterException("Failed to find Icon entity with slug {$iconSlug} and {$this->getFamily()->getName()}.", IconFormatterException::MISSING_ENTITY, $e);
        }

        return $this;
    }

    private function filterIconSlug($iconSlug)
    {
        if($this->hasFamily()) {
            $prefix = $this->getFamily()->getPrefix();
            $pattern = "/^{$prefix}-/";
            return preg_replace($pattern, '', $iconSlug);
        }
        else {
            throw new IconFormatterException("Expected IconFamily to be set for formatter.", IconFormatterException::MISSING_ARGS);
        }
    }

    public function hasIcon()
    {
        return (bool) ($this->icon !== null);
    }

    public function clearIcon()
    {
        $this->icon = null;

        return $this;
    }

    public function getTemplateEntity()
    {
        return $this->template;
    }

    public function setTemplateEntity($templateSlug)
    {
        $template = $this->getIconTemplateEntityBySlug($templateSlug);
        $this->template = $template;

        return $this;
    }

    public function hasTemplateEntity()
    {
        return (bool) ($this->template !== null);
    }

    public function clearTemplateEntity()
    {
        $this->template = null;

        return $this;
    }

    public function isTwigBased()
    {
        if($this->hasTemplateEntity()) {
            return (bool) $this->getTemplateEntity()->getEngine() == 'twig';
        }
        else {
            return false;
        }
    }

    public function getStyles()
    {
        return $this->styles;
    }

    public function setStyles(...$styles)
    {
        $this->styles = $styles;

        return $this;
    }

    public function hasStyles()
    {
        return (bool) ($this->styles !== null);
    }

    public function clearStyles()
    {
        $this->styles = null;

        return $this;
    }

    private function getIconFamilyBySlug($familySlug)
    {
        try {
            $iconFamily = $this->iconFamilyRepo->findOneBySlug($familySlug);
            return $iconFamily;
        } catch(ORMException $e) {
            throw new IconFormatterException("Failed to find IconFamily entity by slug {$familySlug}.", IconFormatterException::MISSING_ENTITY, $e);
        }
    }

    private function getTemplateEntityBySlug($templateSlug)
    {
        try {
            $iconTemplateEntity = $this->iconTemplateRepo->findOneBySlug($templateSlug);
            return $iconTemplateEntity;
        } catch(ORMIconFormatterException $e) {
            throw new IconFormatterException("Failed to find IconTemplate entity by slug {$templateSlug}.", IconFormatterException::MISSING_ENTITY, $e);
        }
    }

    private function validateStyles($styles)
    {
        if(empty($styles) || !$this->getFamily()->hasOptionalClasses()) {
            return true;
        }
        else {
            $opts = $this->getFamily()->getOptionalClasses();
            foreach($styles as $opt) {
                if(!in_array($opt, $opts)) {
                    throw new IconFormatterException("Unable to find {$opt} among styles of IconFamily {$this->getFamily()->getName()}.", IconFormatterException::INVALID_STYLE);
                }
            }
            return true;
        }
    }
}
