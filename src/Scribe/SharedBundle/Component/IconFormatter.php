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
use Scribe\SharedBundle\Component\Template\IconAccessibility,
    Scribe\SharedBundle\Component\Template\IconAttributes;
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
    use IconAccessibility,
        IconAttributes;
    
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

    public function render($familySlug = null, $iconSlug = null, $templateSlug = null, ...$styles)
    {
        $this->ensureArgumentSet('familySlug', $familySlug, 'hasFamily', 'setFamily');
        $this->ensureArgumentSet('iconSlug', $iconSlug, 'hasIcon', 'setIcon');
        $this->ensureTemplateSet($templateSlug);
        $this->verifyStyles($styles);
        $html = $this->renderTemplate();
        $this->clearAttributes();
        return $html;
    }

    private function ensureArgumentSet($argumentType, $argument, $checker, $setter)
    {
        if($argument) {
            $this->{$setter}($argument);
        }
        else if($this->{$checker}()) {
            return true;
        }
        else {
            throw new IconFormatterException("{$argumentType} is not given to IconFormatter::render and {$checker} returns null.");
        }
    }

    private function ensureTemplateSet($templateSlug)
    {
        if($templateSlug) {
            $this->setTemplateEntity($templateSlug);
        }
        else if($this->hasTemplateEntity()) {
            return true;
        }
        else {
            $this->template = $this->getFamily()->getTemplates()[0];
        }
    }

    private function verifyStyles($styles)
    {
        if(!empty($styles)) {
            call_user_func_array(array($this, 'setStyles'), $styles);
        }
        else if($this->hasStyles()) {
            return true;
        }
    }

    private function renderTemplate()
    {
        if($this->isTwigBased()) {
            $twigArgs =  array('family' => $this->getFamily(), 
                               'icon' => $this->getIcon(), 
                               'styles' => $this->getStyles(),
                               'helper' => $this);
            $template = $this
                             ->getTemplateEntity()
                             ->getTemplate();
            return $this
                        ->twig
                        ->render($template, $twigArgs);
        }
        else {
            Throw new IconFormatterException("Unkown template engine referenced.");
        }
    }

    public function clearAttributes()
    {
        $this->clearFamily();
        $this->clearIcon();
        $this->clearTemplateEntity();
        $this->clearStyles();
        $this->clearAccessibilityText();
        $this->setPresentationOnly(false);

        return $this;
    }
}
