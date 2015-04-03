<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node;

use Twig_Environment;
use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class: NodeCreatorCached.
 */
class NodeCreatorCached extends NodeCreator
{
    /**
     * Setup the object instance.
     *
     * @param NodeFamilyRepository $iconFamilyRepo
     * @param Twig_Environment     $twigEnv
     */
    public function __construct(NodeFamilyRepository $iconFamilyRepo, Twig_Environment $twigEnv = null)
    {
        parent::__construct($iconFamilyRepo, $twigEnv);
    }

    /**
     * Render the requested icon.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string|null $template
     * @param string[]    $styles
     *
     * @return string
     *
     * @throws NodeException
     */
    public function render($icon = null, $family = null, $template = null, ...$styles)
    {
        $this->setCurrentStateAndCacheKey($icon, $family, $template, ...$styles);

        if (null === ($renderedHtml = $this->getCacheHandlerChain()->get())) {
            $renderedHtml = parent::render($icon, $family, $template, ...$styles);
            $this->getCacheHandlerChain()->set($renderedHtml);
        }

        $this->resetState();

        return $renderedHtml;
    }

    /**
     * Serializes current context into md5 hash.
     *
     * @param string|null $icon
     * @param string|null $family
     * @param string|null $template
     * @param string[]    $styles
     *
     * @return $this
     */
    protected function setCurrentStateAndCacheKey($icon, $family, $template, ...$styles)
    {
        if ($family !== null) {
            $this->validateFamily($family);
        }

        $this
             ->checkAndSetSlug($icon,     'setNodeSlug')
             ->checkAndSetSlug($template, 'setTemplateSlug')
             ->checkAndSetStyles(...$styles)
        ;

        $this->getCacheHandlerChain()->setKey(...$this->getCachableProperties());

        return $this;
    }

    /**
     * Checks if slug value given and sets relevant property if so.
     *
     * @param string|null $slugVal
     * @param string      $slugSetter
     *
     * @return $this
     */
    protected function checkAndSetSlug($slugVal, $slugSetter)
    {
        if (null !== $slugVal) {
            $this->{$slugSetter}($slugVal);
        }

        return $this;
    }

    /**
     * Checks if styles values given and sets relevant property if so.
     *
     * @param ...string $styles
     *
     * @return $this
     */
    protected function checkAndSetStyles(...$styles)
    {
        if (true === (count($styles) > 0)) {
            $this->setStyles(...$styles);
        }

        return $this;
    }

    /**
     * Iterates available object variables and returns an array of the cachable
     * attributes applicable.
     *
     * @return mixed[]
     */
    protected function getCachableProperties()
    {
        $keyValues = [];
        foreach (get_object_vars($this) as $property => $value) {
            $keyValues[ ] = $property;
            $keyValues[ ] = $this->getCachablePropertyValue($value);
        }

        return $keyValues;
    }

    /**
     * Determines whether property should be cached (i.e., slugs).
     *
     * @param mixed $value
     *
     * @return bool
     */
    protected function getCachablePropertyValue($value)
    {
        if ($value instanceof HandlerChainInterface) {
            return 'handlerChainInstance';
        } elseif ($value instanceof EntityRepository) {
            return 'entityRepository';
        }

        return $value;
    }
}

/* EOF */
