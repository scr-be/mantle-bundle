<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Entity\Icon;
use Symfony\Component\Templating\EngineInterface;
use Scribe\MantleBundle\EntityRepository\IconFamilyRepository;
use Scribe\MantleBundle\Templating\Generator\AbstractGenerator;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorAccessibilityTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorServicesTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\IconTraits\IconCreatorAttributesTrait;

/**
 * IconCreator
 *
 * @package Scribe\MantleBundle\Templating\Generator\Icon
 */
class IconCreator extends AbstractGenerator implements IconCreatorInterface
{
    use IconCreatorServicesTrait,
        IconCreatorAccessibilityTrait,
        IconCreatorAttributesTrait;

    /**
     * Setup the object instance
     *
     * @param IconFamilyRepository   $iconFamilyRepo
     * @param EngineInterface        $engine
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, EngineInterface $engine = null)
    {
        $this->setIconFamilyRepo($iconFamilyRepo);
        parent::__construct($engine);
    }

    /**
     * Set the icon family slug; this can be validated immediately
     *
     * @param  string $slug
     * @return $this
     */
    public function setFamily($slug)
    {
        $this->validateFamily($slug);

        return $this;
    }

    /**
     * Set the icon slug; validation must be postponed until rendering
     *
     * @param  string $slug
     * @return $this
     */
    public function setIcon($slug)
    {
        $this->setIconSlug($slug);

        return $this;
    }

    /**
     * Set the icon template slug; validation must be postponed until rendering
     *
     * @param $slug
     * @return $this
     */
    public function setTemplate($slug = null)
    {
        $this->setTemplateSlug($slug);

        return $this;
    }

    /**
     * Set additional styles for icon; validation must be postpones until rendering
     *
     * @param  string[] $styles
     * @return $this
     */
    public function setStyles(...$styles)
    {
        $this->setOptionalStyles(...$styles);

        return $this;
    }

    /**
     * Reset the instance properties of object to default/undefined state
     *
     * @return $this
     */
    public function resetState()
    {
        $this
            ->resetFamilyEntity()
            ->resetIconEntity()
            ->resetIconSlug()
            ->resetTemplateEntity()
            ->resetTemplateSlug()
            ->resetOptionalStyles()
            ->resetAriaHidden()
            ->resetAriaLabel()
            ->resetAriaRole()
        ;

        return $this;
    }

    /**
     * Render the requested icon
     *
     * @param  string|null $family
     * @param  string|null $icon
     * @param  string|null $template
     * @param  string[]    $styles
     * @return string
     * @throws IconException
     */
    public function render($icon = null, $family = null, $template = null, ...$styles)
    {
        $html = $this
            ->validateFamily($family)
            ->validateIcon($icon)
            ->validateTemplate($template)
            ->validateStyles(...$styles)
            ->validateEngine()
            ->renderTemplate()
        ;

        $this->resetState();

        return $html;
    }

    /**
     * Assign and/or validate the icon family entity
     *
     * @param  string|null $slug
     * @return $this
     * @throws IconException
     */
    protected function validateFamily($slug = null)
    {
        if (null !== $slug) {
            $this->lookupFamily($slug);
        }

        if (true !== $this->hasFamilyEntity()) {

            throw new IconException(
                "An icon family type was not provided.",
                IconException::CODE_MISSING_ARGS
            );
        }

        return $this;
    }

    /**
     * Query doctrine for the requested icon family entity
     *
     * @param  string|null $slug
     * @return $this
     * @throws IconException
     */
    protected function lookupFamily($slug = null)
    {
        try {
            $family = $this
                ->getIconFamilyRepo()
                ->loadIconFamilyBySlug($slug)
            ;

            $this->setFamilyEntity($family);
        }
        catch(\Exception $e) {

            throw new IconException(
                sprintf("IconFamily with slug %s could not be found.", $slug),
                IconException::CODE_MISSING_ENTITY,
                $e
            );
        }

        return $this;
    }

    /**
     * validateIcon
     *
     * @param  null|string $slug
     * @return $this
     * @throws IconException
     */
    protected function validateIcon($slug = null)
    {
        if (null !== $slug) {
            $this->setIconSlug($slug);
        }

        if (true !== $this->hasIconSlug()) {
            throw new IconException(
                "An icon type was not provided.",
                IconException::CODE_MISSING_ARGS
            );
        }

        $this->lookupIcon();

        return $this;
    }


    /**
     * Check if the icon slug is valid or not
     *
     * @return $this
     * @throws IconException
     */
    private function lookupIcon()
    {
        if (true !== $this->hasFamilyEntity()) {

            throw new IconException(
                "Could not validate/lookup icon entity without a valid icon family entity.",
                IconException::CODE_INVALID_VALIDATION_ORDER
            );
        }

        $slug  = $this->getIconSlugFiltered();
        $icons = $this
            ->getFamilyEntity()
            ->getIcons()
            ->filter(
                function($familyIcon) use ($slug) {
                    if ($familyIcon->getSlug() == $slug) {
                        return true;
                    }
                    return false;
                }
            )
        ;

        if (false === ($icons instanceof ArrayCollection) || 1 !== $icons->count()) {
            if (false === ($icons = $this->lookupIconByAlias($slug)) || 1 !== $icons->count()) {
                throw new IconException(
                    sprintf("Could not find icon slug %s in icon family %s.", $slug, $this->getFamilyEntity()->getName()),
                    IconException::CODE_MISSING_ENTITY
                );
            }
        }

        $this->setIconEntity($icons->first());

        return $this;
    }

    private function lookupIconByAlias($alias)
    {
        foreach ($this->getFamilyEntity()->getIcons() as $icon) {
            if (in_array($alias, $icon->getAliases())) {
                return new ArrayCollection([$icon]);
            }
        }

        return false;
    }

    /**
     * Get the icon slug; filter the prefix off if it exists
     *
     * @return string
     */
    protected function getIconSlugFiltered()
    {
        $slug   = $this->getIconSlug();
        $prefix = $this
            ->getFamilyEntity()
            ->getPrefix()
        ;

        if (substr($slug, 0, strlen($prefix) + 1) == $prefix . '-') {

            return substr($slug, strlen($prefix) + 1);
        }

        return $slug;
    }

    /**
     * Check if the supplied template slug is valid or select one for the icon
     * family based on priority.
     *
     * @param  string|null $slug
     * @return $this
     */
    protected function validateTemplate($slug = null)
    {
        if (null !== $slug) {
            $this->setTemplateSlug($slug);
        }

        $this->lookupTemplate();

        return $this;
    }

    /**
     * Check if the icon template slug is valid or not, or select one
     *
     * @return $this
     * @throws IconException
     */
    private function lookupTemplate()
    {
        if (true !== $this->hasFamilyEntity()) {

            throw new IconException(
                "Could not validate/lookup icon template entity without a valid icon family entity.",
                IconException::CODE_INVALID_VALIDATION_ORDER
            );
        }

        $slug      = $this->getTemplateSlug();
        $templates = $this
            ->getFamilyEntity()
            ->getTemplates()
        ;

        if (true !== ($templates->count() > 0)) {

            throw new IconException(
                sprintf("No icon templates are associated with the %s icon family.", $this->getFamilyEntity()->getName()),
                IconException::CODE_MISSING_ENTITY
            );
        }

        if (null !== $slug) {
            $templates = $templates->filter(
                function($familyTemplate) use ($slug) {

                    return (bool) ($familyTemplate->getSlug() == $slug);
                }
            );

            if (false === ($templates instanceof ArrayCollection) || 1 !== $templates->count()) {

                throw new IconException(
                    sprintf("Could not find icon template slug %s in icon family %s.", $slug, $this->getFamilyEntity()->getName()),
                    IconException::CODE_MISSING_ENTITY
                );
            }
        }

        $this->setTemplateEntity($templates->first());

        return $this;
    }

    /**
     * Provides final opportunity to set optional styles and then performs
     * validation against them.
     *
     * @param  string[] $styles
     * @return $this
     */
    protected function validateStyles(...$styles)
    {
        if (true === (count($styles) > 0)) {
            $this
                ->resetOptionalStyles()
                ->setOptionalStyles(...$styles)
            ;
        }

        $this->lookupStyles();

        return $this;
    }

    /**
     * Performs validation that the requested additional styles are valid for the
     * given font family specified.
     *
     * @return $this
     * @throws IconException
     */
    private function lookupStyles()
    {
        if (false === (count($this->getFamilyEntity()->getOptionalClasses()) > 0) &&
            true === (count($this->getOptionalStyles()) > 0))
        {
            throw new IconException(
                sprintf("No available optional styles to select for %s font family.", $this->getFamilyEntity()->getName()),
                IconException::CODE_INVALID_STYLE
            );
        }

        foreach ($this->getOptionalStyles() as $style) {
            if (false === in_array($style, $this->getFamilyEntity()->getOptionalClasses())) {
                throw new IconException(
                    sprintf("The requested optional style %s is not compatible with the %s font family.", $style, $this->getFamilyEntity()->getName()),
                    IconException::CODE_INVALID_STYLE
                );
            }
        }

        return $this;
    }

    /**
     * Confirms we have the correct templating engine for the selected icon template
     *
     * @return $this
     */
    protected function validateEngine()
    {
        if (false === ($type = $this->getEngineType())) {

            throw new IconException(
                "Template engine type could not be determined, support cannot be verified.",
                IconException::CODE_INVALID_ARGS
            );
        }

        if ($this->getTemplateEntity()->getEngine() !== $type) {

            throw new IconException(
                sprintf(
                    "The icon template requested %s engine, but we are running the %s engine.",
                    $this->getTemplateEntity()->getEngine(), $type
                ), IconException::CODE_INVALID_ARGS
            );
        }

        return $this;
    }

    /**
     * Creates helper object to expose accessibility data
     * to template 
     *
     * @return stdClass 
     */
    protected function templateHelper()
    {
        $helper = new \stdClass;
        $helper->hasAriaRole = $this->hasAriaRole();
        $helper->getAriaRole = $this->getAriaRole();
        $helper->isAriaHidden = $this->isAriaHidden();
        $helper->hasAriaLabel = $this->hasAriaLabel();
        $helper->getAriaLabel = $this->getAriaLabel();

        return $helper;
    }
    

    /**
     * Render the template and return the resulting output
     *
     * @return string
     */
    protected function renderTemplate()
    {
        $template = $this
            ->getTemplateEntity()
            ->getTemplate()
        ;

        $arguments = [
            'family' => $this->getFamilyEntity(),
            'icon'   => $this->getIconEntity(),
            'styles' => $this->getOptionalStyles(),
            'helper' => $this->templateHelper()
        ];

        return $this
            ->getEngine()
            ->render($template, $arguments)
        ;
    }
}

/* EOF */
