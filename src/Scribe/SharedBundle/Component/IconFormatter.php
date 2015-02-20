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

use Scribe\SharedBundle\Entity\IconRepository,
    Scribe\SharedBundle\Entity\IconFamilyRepository;

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
    
    public function __construct(IconRepository $iconRepo, IconFamilyRepository $iconFamilyRepo) 
    {
        $this->iconRepo = $iconRepo;
        $this->iconFamilyRepo = $iconFamilyRepo;
    }

    public function render($familyName, $iconName, $template = null)
    {
        $famly = $this->getIconFamilyByName($familyName);
        $icon = $this->getIconByName($iconName);
    }

    public function renderTemplate($template, $args)
    {
        $engine = $template->getEngine();
        if($engine == 'twig') {

        }
        else {
            Throw new Exception("Unkown template engine called, {$engine}.");
        }
    }

    public function getIconByName($iconName)
    {
        try {
            $icon = $this->iconRepo->findOneByName($iconName);
            return $icon;
        } catch(Exception $e) {
        }
    }

    public function getIconFamilyByName($familyName)
    {
        try {
            $iconFamily = $this->iconFamilyRepo->findOneByName($familyName);
            return $iconFamily;
        } catch(Exception $e) {
        }
    }
}
