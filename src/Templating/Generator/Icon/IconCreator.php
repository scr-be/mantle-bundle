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

use Scribe\MantleBundle\Doctrine\Entity\Icon\Icon;
use Scribe\MantleBundle\Doctrine\Entity\Icon\IconTemplate;
use Twig_Environment;
use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Repository\Icon\IconFamilyRepository;
use Scribe\MantleBundle\Templating\Generator\AbstractTwigGenerator;
use Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorException;
use Scribe\MantleBundle\Templating\Generator\Icon\Exception\IconCreatorORMException;
use Scribe\MantleBundle\Templating\Generator\Icon\Model\IconCreatorAccessibilityTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\Model\IconCreatorServicesTrait;
use Scribe\MantleBundle\Templating\Generator\Icon\Model\IconCreatorAttributesTrait;

/**
 * IconCreator.
 */
class IconCreator extends AbstractTwigGenerator implements IconCreatorInterface
{
    use IconCreatorServicesTrait,
        IconCreatorAccessibilityTrait,
        IconCreatorAttributesTrait;

    /**
     * Setup the object instance.
     *
     * @param IconFamilyRepository $iconFamilyRepo
     * @param Twig_Environment     $engineEnvironment
     */
    public function __construct(IconFamilyRepository $iconFamilyRepo, Twig_Environment $engineEnvironment = null)
    {
        $this->setIconFamilyRepo($iconFamilyRepo);
        $this->setEngineEnvironment($engineEnvironment);
    }

    /**
     * Set the icon family slug; this can be validated immediately.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setFamily($slug)
    {
        $this->validateFamily($slug);

        return $this;
    }

    /**
     * Set the icon slug; validation must be postponed until rendering.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setIcon($slug)
    {
        $this->setIconSlug($slug);

        return $this;
    }

    /**
     * Set the icon template slug; validation must be postponed until rendering.
     *
     * @param $slug
     *
     * @return $this
     */
    public function setTemplate($slug = null)
    {
        $this->setTemplateSlug($slug);

        return $this;
    }

    /**
     * Set additional styles for icon; validation must be postpones until rendering.
     *
     * @param string[] $styles
     *
     * @return $this
     */
    public function setStyles(...$styles)
    {
        $this->setOptionalStyles(...$styles);

        return $this;
    }

    /**
     * Reset the instance properties of object to default/undefined state.
     *
     * @return $this
     */
    public function resetState()
    {
        $this
            ->resetFamilyEntity()
            ->resetIconFamilySlug()
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
     * Render the requested icon.
     *
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string,...  $styles
     *
     * @return string
     *
     * @throws IconCreatorException
     */
    public function render($icon = null, $family = null, ...$styles)
    {
        list($icon, $family) = $this->canonicalizeSlugs($icon, $family);

        $html = $this
            ->validateFamily($family, $icon)
            ->validateIcon($icon)
            ->validateTemplate(null)
            ->validateStyles(...$styles)
            ->validateEngine()
            ->renderTemplate()
        ;

        $this->resetState();

        return $html;
    }

    protected function canonicalizeSlugs(...$slugs) {
        $canonicalizedSlugs = [];

        for ($i = 0; $i < count($slugs); $i++) {
            $canonicalizedSlugs[] = preg_replace('#[^a-z0-9_-]#i', '', $slugs[$i]);
        }

        return $canonicalizedSlugs;
    }

    /**
     * Assign and/or validate the icon family entity.
     *
     * @param string|null $familySlug
     * @param string|null $iconSlug
     *
     * @return $this
     *
     * @throws IconCreatorException
     */
    protected function validateFamily($familySlug = null, $iconSlug = null)
    {
        $this->attemptForgivingLookupFamily($familySlug, $iconSlug);

        if (true !== $this->hasFamilyEntity()) {
            throw new IconCreatorException(
                'An icon family type was not provided.',
                IconCreatorException::CODE_MISSING_ARGS
            );
        }

        return $this;
    }

    /**
     * Allow for single-argument look-ups that include family, such as fa-book for "Font Awesome" icon "Book".
     *
     * @param string|null $familySlug
     * @param string|null $iconSlug
     *
     * @return $this
     */
    protected function attemptForgivingLookupFamily($familySlug = null, $iconSlug = null)
    {
        if (null !== $familySlug) {
            $this->lookupFamily($familySlug);
        }

        if (null === $familySlug && null === $iconSlug) {
            return $this;
        }

        try {
            if (false !== ($slugSeparatorPosition = strpos($iconSlug, '-')) && $slugSeparatorPosition === 2) {
                $this->lookupFamily(substr($iconSlug, 0, 2));
            }
        } catch (\Exception $e) {
            $this->resetIconFamilySlug();
        }

        return $this;
    }

    /**
     * Query doctrine for the requested icon family entity.
     *
     * @param string|null $slug
     *
     * @return $this
     *
     * @throws IconCreatorORMException
     */
    protected function lookupFamily($slug = null)
    {
        try {
            $this->setIconFamilySlug($slug);

            $family = $this
                ->getIconFamilyRepo()
                ->loadIconFamilyBySlug($slug)
            ;

            $this->setFamilyEntity($family);
        } catch (\Exception $e) {
            throw new IconCreatorORMException(
                'IconFamily with slug %s could not be found.', IconCreatorORMException::CODE_ORM_STATE_ENTITY_MISSING,
                $e, null, $slug
            );
        }

        return $this;
    }

    /**
     * validateIcon.
     *
     * @param null|string $slug
     *
     * @return $this
     *
     * @throws IconCreatorException
     */
    protected function validateIcon($slug = null)
    {
        if (null !== $slug) {
            $this->setIconSlug($slug);
        }

        if (true !== $this->hasIconSlug()) {
            throw new IconCreatorException('An icon type was not provided.', IconCreatorException::CODE_MISSING_ARGS);
        }

        $this->lookupIcon();

        return $this;
    }

    /**
     * Checks if the icon slug is valid or not.
     *
     * @return $this
     *
     * @throws IconCreatorORMException
     */
    private function lookupIcon()
    {
        if (true !== $this->hasFamilyEntity()) {
            throw new IconCreatorException(
                'Could not validate/lookup icon entity without a valid icon family entity.',
                IconCreatorException::CODE_TEMPLATING_GENERATOR_GENERIC
            );
        }

        $slug = $this->getIconSlugFiltered();
        $icons = $this
            ->getFamilyEntity()
            ->getIcons()
            ->filter(
                function (Icon $icon) use ($slug) {
                    return (bool) ((string) $icon->getSlug() === (string) $slug);
                }
            )
        ;

        if ((false === ($icons instanceof ArrayCollection) || 1 !== $icons->count()) &&
            (false === ($icons = $this->lookupIconByAlias($slug)) || 1 !== $icons->count())) {
            throw new IconCreatorORMException(
                'Could not find icon slug %s in icon family %s.',
                IconCreatorORMException::CODE_ORM_STATE_ENTITY_MISSING, null, null, $slug, $this->getFamilyEntity()->getName()
            );
        }

        $this->setIconEntity($icons->first());

        return $this;
    }

    /**
     * If the icon slug isn't valid, perhaps one of the icon aliases is...
     *
     * @param string $alias
     *
     * @return bool|ArrayCollection
     */
    private function lookupIconByAlias($alias)
    {
        foreach ($this->getFamilyEntity()->getIcons() as $icon) {
            if (in_array($alias, $icon->getAliases(), true)) {
                return new ArrayCollection([$icon]);
            }
        }

        return false;
    }

    /**
     * Get the icon slug; filter the prefix off if it exists.
     *
     * @return string
     */
    protected function getIconSlugFiltered()
    {
        $slug = $this->getIconSlug();

        $prefix = $this
            ->getFamilyEntity()
            ->getPrefix()
        ;

        if (substr($slug, 0, strlen($prefix) + 1) === $prefix.'-') {
            return substr($slug, strlen($prefix) + 1);
        }

        return $slug;
    }

    /**
     * Check if the supplied template slug is valid or select one for the icon
     * family based on priority.
     *
     * @param string|null $slug
     *
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
     * Check if the icon template slug is valid or not, or select one.
     *
     * @return $this
     *
     * @throws IconCreatorException
     * @throws IconCreatorORMException
     */
    private function lookupTemplate()
    {
        if (true !== $this->hasFamilyEntity()) {
            throw new IconCreatorException(
                'Could not validate/lookup icon template entity without a valid icon family entity.',
                IconCreatorException::CODE_TEMPLATING_GENERATOR_GENERIC
            );
        }

        $slug = $this->getTemplateSlug();
        $templates = $this
            ->getFamilyEntity()
            ->getTemplates()
        ;

        if (true !== ($templates->count() > 0)) {
            throw new IconCreatorORMException(
                sprintf('No icon templates are associated with the %s icon family.', $this->getFamilyEntity()->getName()),
                IconCreatorORMException::CODE_ORM_STATE_ENTITY_MISSING
            );
        }

        if (null !== $slug) {
            $templates = $templates->filter(
                function (IconTemplate $familyTemplate) use ($slug) {
                    return (bool) ($familyTemplate->getSlug() === $slug);
                }
            );

            if (false === ($templates instanceof ArrayCollection) || 1 !== $templates->count()) {
                throw new IconCreatorORMException(
                    sprintf('Could not find icon template slug %s in icon family %s.', $slug, $this->getFamilyEntity()->getName()),
                    IconCreatorORMException::CODE_ORM_STATE_ENTITY_MISSING
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
     * @param string[] $styles
     *
     * @return $this
     */
    protected function validateStyles(...$styles)
    {
        if (true === (count($styles) > 0)) {
            $this
                ->resetOptionalStyles()
                ->setOptionalStyles(...$styles);
        }

        $this->lookupStyles();

        return $this;
    }

    /**
     * Performs validation that the requested additional styles are valid for the
     * given font family specified.
     *
     * @return $this
     *
     * @throws IconCreatorException
     */
    private function lookupStyles()
    {
        $optionalStyles = $this->getOptionalStyles();

        array_walk($optionalStyles, function ($style) {
            if (true === in_array($style, $this->getFamilyEntity()->getOptionalClasses(), true)) {
                return;
            }

            throw new IconCreatorException(
                sprintf('The requested optional style %s is not compatible with the %s font family.', $style, $this->getFamilyEntity()->getName()),
                IconCreatorException::CODE_INVALID_STYLE
            );
        });

        return $this;
    }

    /**
     * Confirms we have the correct templating engine for the selected icon template.
     *
     * @return $this
     */
    protected function validateEngine()
    {
        if (false === ($type = $this->getEngineType())) {
            throw new IconCreatorException(
                'Template engine type could not be determined, support cannot be verified.',
                IconCreatorException::CODE_INVALID_ARGS
            );
        }

        if ($this->getTemplateEntity() === null) {
            throw new IconCreatorException(
                'The icon template entity is invalid; cannot verify the template engine.', IconCreatorException::CODE_INVALID_ARGS
            );
        }

        if ($this->getTemplateEntity()->getEngine() !== $type) {
            throw new IconCreatorException(
                sprintf('The icon template requested %s engine, but we are running the %s engine.',
                        $this->getTemplateEntity()->getEngine(), $type),
                IconCreatorException::CODE_INVALID_ARGS
            );
        }

        return $this;
    }

    /**
     * Creates helper object to expose accessibility data
     * to template.
     *
     * @return \stdClass
     */
    protected function templateHelper()
    {
        $helper = new \stdClass();
        $helper->hasAriaRole = $this->hasAriaRole();
        $helper->getAriaRole = $this->getAriaRole();
        $helper->isAriaHidden = $this->isAriaHidden();
        $helper->hasAriaLabel = $this->hasAriaLabel();
        $helper->getAriaLabel = $this->getAriaLabel();

        return $helper;
    }

    /**
     * Render the template and return the resulting output.
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
            'icon' => $this->getIconEntity(),
            'styles' => $this->getOptionalStyles(),
            'helper' => $this->templateHelper(),
        ];

        return $this->getEngineRendering($template, $arguments);
    }
}

/* EOF */
