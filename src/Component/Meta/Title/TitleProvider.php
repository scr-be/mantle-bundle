<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Meta\Title;

use Scribe\Teavee\ObjectCacheBundle\DependencyInjection\Aware\CacheManagerAwareTrait;
use Scribe\MantleBundle\Component\Bundle\BundleInformationInterface;
use Scribe\MantleBundle\Doctrine\Entity\Meta\MetaTitle;
use Scribe\MantleBundle\Doctrine\Repository\Meta\MetaTitleRepository;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TitleProvider.
 */
class TitleProvider
{
    use CacheManagerAwareTrait;

    /**
     * @var MetaTitleRepository
     */
    protected $metaTitleRepo;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $bundle;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @param MetaTitleRepository        $metaTitleRepo
     * @param BundleInformationInterface $bundleInfo
     * @param TranslatorInterface        $translator
     */
    public function __construct(MetaTitleRepository $metaTitleRepo, BundleInformationInterface $bundleInfo, TranslatorInterface $translator)
    {
        $this
            ->setMetaTitleRepo($metaTitleRepo)
            ->setLocale($translator->getLocale())
            ->extractBundleParts($bundleInfo);
    }

    /**
     * @param MetaTitleRepository $repo
     *
     * @return $this
     */
    public function setMetaTitleRepo(MetaTitleRepository $repo)
    {
        $this->metaTitleRepo = $repo;

        return $this;
    }

    /**
     * @return MetaTitleRepository
     */
    public function getMetaTitleRepo()
    {
        return $this->metaTitleRepo;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = (string) $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $bundle
     *
     * @return $this
     */
    public function setBundle($bundle)
    {
        $this->bundle = (string) $bundle;

        return $this;
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * @param string $controller
     *
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = (string) $controller;

        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = (string) $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return $this
     */
    protected function extractBundleParts(BundleInformationInterface $bundleInfo)
    {
        list(, $bundle, $controller, $action) = $bundleInfo->getAll();

        $this
            ->setBundle($bundle)
            ->setController($controller)
            ->setAction($action);

        return $this;
    }

    /**
     * @return string
     */
    public function determineMetaTitle()
    {
        if (false !== ($title = $this->lookupExactMatch())) {
            return $title;
        }
        if (false !== ($title = $this->lookupFuzzyMatch())) {
            return $title;
        }

        return $this->lookupDefault();
    }

    /**
     * @return bool|string
     */
    protected function lookupExactMatch()
    {
        try {
            $result = $this->metaTitleRepo->findOneByExactStringMatches(
                $this->getLocale(),
                $this->getBundle(),
                $this->getController(),
                $this->getAction()
            );
        } catch (\Exception $e) {
            return false;
        }

        return $this->validateDoctrineResult($result);
    }

    /**
     * @return bool|string
     */
    protected function lookupFuzzyMatch()
    {
        if (false !== ($title = $this->lookupFuzzyMatchWithNoAction())) {
            return $title;
        }

        if (false !== ($title = $this->lookupFuzzyMatchWithNoActionOrController())) {
            return $title;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    protected function lookupFuzzyMatchWithNoAction()
    {
        try {
            $result = $this->metaTitleRepo->findOneByFizzyStringMatches(
                $this->getLocale(),
                $this->getBundle(),
                $this->getController()
            );
        } catch (\Exception $e) {
            return false;
        }

        return $this->validateDoctrineResult($result);
    }

    /**
     * @return bool|string
     */
    protected function lookupFuzzyMatchWithNoActionOrController()
    {
        try {
            $result = $this->metaTitleRepo->findOneByFizzyStringMatches(
                $this->getLocale(),
                $this->getBundle(),
                null,
                null
            );
        } catch (\Exception $e) {
            return false;
        }

        return $this->validateDoctrineResult($result);
    }

    /**
     * @return string
     */
    protected function lookupDefault()
    {
        return (string) ucwords($this->getBundle());
    }

    /**
     * @param mixed $result
     *
     * @return bool|string
     */
    protected function validateDoctrineResult($result)
    {
        if (is_string($result) && strlen($result) > 0) {
            return (string) $result;
        }

        if (is_array($result) && array_key_exists('title', $result)) {
            return (string) $result['title'];
        }

        if ($result instanceof MetaTitle) {
            return (string) $result->getTitle();
        }

        return false;
    }
}
