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

    public function render($family, $name, $template = null)
    {
        $name = $this->getIconByName($name);
        var_dump($this->iconRepo); 
    }

    public function getIconByName($name)
    {
        try {
            $icon = $this->iconRepo->findOneByName($name);
            return $icon;
        } 
        catch(Exception $e) {
        }
    }
}
