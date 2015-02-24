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
        $icon = $this->getIconBySlug($iconSlug);
        if($templateSlug) {
            $templateEnt = getTemplateBySlug($templateSlug);
        }
        else {
            $templateEnt = $family->getTemplates()[0];
        }
        $this->validateOptionalClasses($optionalClasses, $family);
        return $this->renderTemplate($templateEnt, $family, $icon, $optionalClasses);
    }

    public function renderTemplate($templateEnt, $family, $icon, $optionalClasses)
    {
        $engine = $templateEnt->getEngine();
        if($engine == 'twig') {
            $template = $templateEnt->getTemplate();
            return $this->twig->render($template, array('family' => $family, 'icon' => $icon, 'optionalClasses' => $optionalClasses));
        }
        else {
            Throw new Exception("Unkown template engine called: {$engine}.");
        }
    }

    public function getIconBySlug($iconSlug)
    {
        try {
            $icon = $this->iconRepo->findOneBySlug($iconSlug);
            return $icon;
        } catch(ORMException $e) {
            throw new Exception("Failed to find Icon entity by name {$iconSlug}.", 0, $e);
        }
    }

    public function getIconFamilyBySlug($familySlug)
    {
        try {
            $iconFamily = $this->iconFamilyRepo->findOneBySlug($familySlug);
            return $iconFamily;
        } catch(ORMException $e) {
            throw new Exception("Failed to find IconFamily entity by name {$familySlug}.", 0, $e);
        }
    }

    public function getTemplateBySlug($templateSlug)
    {
        try {
            $iconTemplate = $this->iconTemplateRepo->findOneBySlug($templateSlug);
            return $iconTemplate;
        } catch(ORMException $e) {
            throw new Exception("Failed to find IconTemplate entity by slug {$templateSlug}.", 0, $e);
        }
    }

    public function validateOptionalClasses($optionalClasses, $family)
    {
        if(empty($optionalClasses) || !$family->hasOptionalClasses()) {
            return true;
        }
        else {
            $opts = $family->getOptionalClasses();
            foreach($optionalClasses as $opt) {
                if(!in_array($opt, $opts)) {
                    throw new Exception("Unable to find {$opt} among optionalClasses of IconFamily {$family->getSlug()}.");
                }
            }
            return true;
        }
    }
}
