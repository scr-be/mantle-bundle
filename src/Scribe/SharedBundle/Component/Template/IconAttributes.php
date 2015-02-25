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

    public function setIcon($iconSlug)
    {
        $icon = $this->getIconBySlug($iconSlug);
        $this->icon = $icon;

        return $this;
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
        $this->validateStyles($styles);
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


    private function getIconBySlug($iconSlug)
    {
        try {
            $icon = $this->iconRepo->findOneBySlug($iconSlug);
            return $icon;
        } catch(ORMException $e) {
            throw new IconFormatterException("Failed to find Icon entity by slug {$iconSlug}.", 0, $e);
        }
    }

    private function getIconFamilyBySlug($familySlug)
    {
        try {
            $iconFamily = $this->iconFamilyRepo->findOneBySlug($familySlug);
            return $iconFamily;
        } catch(ORMException $e) {
            throw new IconFormatterException("Failed to find IconFamily entity by slug {$familySlug}.", 0, $e);
        }
    }

    private function getTemplateEntityBySlug($templateSlug)
    {
        try {
            $iconTemplateEntity = $this->iconTemplateRepo->findOneBySlug($templateSlug);
            return $iconTemplateEntity;
        } catch(ORMIconFormatterException $e) {
            throw new IconFormatterException("Failed to find IconTemplate entity by slug {$templateSlug}.", 0, $e);
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
                    throw new IconFormatterException("Unable to find {$opt} among styles of IconFamily {$this->getFamily()->getName()}.");
                }
            }
            return true;
        }
    }
}
