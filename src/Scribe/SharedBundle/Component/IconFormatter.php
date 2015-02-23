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
    
    public function __construct(IconRepository $iconRepo, IconFamilyRepository $iconFamilyRepo, IconTemplateRepository $iconTemplateRepo) 
    {
        $this->iconRepo = $iconRepo;
        $this->iconFamilyRepo = $iconFamilyRepo;
    }

    public function render($familyName, $iconName, $templateSlug = null)
    {
        $family = $this->getIconFamilyByName($familyName);
        $icon = $this->getIconByName($iconName);
        if($templateSlug) {
            $template = getTemplateBySlug($templateSlug);
        }
        else {
            $template = $family->getTemplates()[0];
        }
    }

    public function renderTemplate($template, $args)
    {
        $engine = $template->getEngine();
        if($engine == 'twig') {

        }
        else {
            Throw new Exception("Unkown template engine called: {$engine}.");
        }
    }

    public function getIconByName($iconName)
    {
        try {
            $icon = $this->iconRepo->findOneByName($iconName);
            return $icon;
        } catch(ORMException $e) {
            throw new Exception("Failed to find Icon entity by name {$iconName}.", 0, $e);
        }
    }

    public function getIconFamilyByName($familyName)
    {
        try {
            $iconFamily = $this->iconFamilyRepo->findOneByName($familyName);
            return $iconFamily;
        } catch(ORMException $e) {
            throw new Exception("Failed to find IconFamily entity by name {$familyName}.", 0, $e);
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
}
