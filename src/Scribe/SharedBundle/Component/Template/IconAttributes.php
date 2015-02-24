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

    private $optionalClasses = null;

    public function getFamily()
    {
        return $this->family;
    }

    public function setFamily($familySlug)
    {
        $family = $this->getIconFamilyBySlug($familySlug);
        $this->family = $family;
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

    public function getOptionalClasses()
    {
        return $this->optionalClasses;
    }

    public function setOptionalClasses($optionalClasses)
    {
        $this->validateOptionalClasses($optionalClasses);
        $this->optionalClasses = $optionalClasses;
    }

    public function hasOptionalClasses()
    {
        return (bool) ($this->optionalClasses !== null);
    }

    public function clearOptionalClasses()
    {
        $this->optionalClasses = null;

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

    private function validateOptionalClasses($optionalClasses)
    {
        if(empty($optionalClasses) || !$this->getFamily()->hasOptionalClasses()) {
            return true;
        }
        else {
            $opts = $this->getFamily()->getOptionalClasses();
            foreach($optionalClasses as $opt) {
                if(!in_array($opt, $opts)) {
                    throw new IconFormatterException("Unable to find {$opt} among optionalClasses of IconFamily {$this->getFamily()->getName()}.");
                }
            }
            return true;
        }
    }
}
