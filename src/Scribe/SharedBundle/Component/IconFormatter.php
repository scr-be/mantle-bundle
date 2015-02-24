<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Component;

use Doctrine\ORM\EntityNotFoundException;
use Twig_Extension;
use Scribe\SharedBundle\Component\Exceptions\IconFormatterException;
use Scribe\SharedBundle\Component\Template\IconAccessibility;
use Scribe\SharedBundle\Entity\IconRepository,
    Scribe\SharedBundle\Entity\IconFamilyRepository,
    Scribe\SharedBundle\Entity\IconTemplateRepository;

/**
 * IconFormatter
 *
 * @package Scribe\SharedBundle\Component
 */
class IconFormatter 
{
    /**
     * import traits 
     */
    use IconAccessibility;
    
    /**
     * @type IconRepositoy 
     */
    private $iconRepo;

    /**
     * @var IconFamilyRepository 
     */
    private $iconFamilyRepo;

    /**
     * @var IconTemplateRepository 
     */
    private $iconTemplateRepo;

    /**
     * @var Twig_Environment 
     */
    private $twig;
    
    public function __construct(IconRepository $iconRepo, IconFamilyRepository $iconFamilyRepo, IconTemplateRepository $iconTemplateRepo) 
    {
        $this->iconRepo = $iconRepo;
        $this->iconFamilyRepo = $iconFamilyRepo;
        $this->iconTemplateRepo = $iconTemplateRepo;
        $this->twig = new \Twig_Environment(new \Twig_Loader_String());
    }

    public function render($familySlug, $iconSlug, $templateSlug = null, ...$optionalClasses)
    {
        $family = $this->getIconFamilyBySlug($familySlug);
        $iconSlug = $this->filterIconSlug($iconSlug, $family->getPrefix());
        $icon = $this->getIconBySlug($iconSlug);
        $templateEnt = $this->getTemplateEntity($templateSlug, $family);
        $this->validateOptionalClasses($optionalClasses, $family);
        return $this->renderTemplate($templateEnt, $family, $icon, $optionalClasses);
    }

    private function getTemplateEntity($templateSlug, $family)
    {
        if($templateSlug) {
            return getTemplateBySlug($templateSlug);
        }
        else {
            return $family->getTemplates()[0];
        }
    }

    private function renderTemplate($templateEnt, $family, $icon, $optionalClasses)
    {
        $engine = $templateEnt->getEngine();
        if($engine == 'twig') {
            $template = $templateEnt->getTemplate();
            $twigArgs =  array('family' => $family, 
                               'icon' => $icon, 
                               'optionalClasses' => $optionalClasses,
                               'helper' => $this);
            return $this
                        ->twig
                        ->render($template, $twigArgs);
        }
        else {
            Throw new IconFormatterException("Unkown template engine called: {$engine}.");
        }
    }

    private function filterIconSlug($iconSlug, $prefix)
    {
        $pattern = "/^{$prefix}-/";
        return preg_replace($pattern, '', $iconSlug);
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

    private function getTemplateBySlug($templateSlug)
    {
        try {
            $iconTemplate = $this->iconTemplateRepo->findOneBySlug($templateSlug);
            return $iconTemplate;
        } catch(ORMIconFormatterException $e) {
            throw new IconFormatterException("Failed to find IconTemplate entity by slug {$templateSlug}.", 0, $e);
        }
    }

    private function validateOptionalClasses($optionalClasses, $family)
    {
        if(empty($optionalClasses) || !$family->hasOptionalClasses()) {
            return true;
        }
        else {
            $opts = $family->getOptionalClasses();
            foreach($optionalClasses as $opt) {
                if(!in_array($opt, $opts)) {
                    throw new IconFormatterException("Unable to find {$opt} among optionalClasses of IconFamily {$family->getName()}.");
                }
            }
            return true;
        }
    }
}
