<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Helper\Search;

use Datetime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\SharedBundle\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\SharedBundle\Component\Symfony\BundleInformation;

/**
 * Class Search
 */
class Search implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $searchPath = null;

    /**
     * @var boolean
     */
    protected $cache = false;

    /**
     * @var int
     */
    protected $limit = 12;

    /**
     * @var int
     */
    protected $timeToLive = 0;

    /**
     * @var string
     */
    protected $template = null;

    /**
     * @var string
     */
    protected $templateEngine = null;

    /**
     * @var string
     */
    protected $formSelector = null;

    /**
     * @var Datetime
     */
    protected $datetime = null;

    /**
     * @var BundleInformation
     */
    protected $bundleInfo = null;

    /**
     * constructor
     */
    public function __construct(ContainerInterface $container, $formSelector = '#form-search-input')
    {
        $this->setContainer($container);

        $this
            ->setFormSelector($formSelector)
            ->setTemplateEngine('Hogan')
            ->setTemplate('<span class="label label-info pull-right">{{ type }}</span><p>{{ value }} <span class="mute">{{more}}</span></p>')
            ->setDatetime(new Datetime)
            ->setBundleInfo($container->get('s.symfony.bundleinfo'))
        ;
    }

    public function setBundleInfo(BundleInformation $bundleInfo)
    {
        $this->bundleInfo = $bundleInfo;

        return $this;
    }

    public function getBundleInfo()
    {
        return $this->bundleInfo;
    }

    public function setDatetime(Datetime $d)
    {
        $this->datetime = $d;

        return $this;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getDatetimeFormatted($format = 'Ymd\_G_T')
    {
        return $this->datetime->format($format);
    }

    /**
     * @param string $selector
     */
    public function setFormSelector($selector = null)
    {
        $this->formSelector = $selector;

        return $this;
    }

    public function getFormSelector()
    {
        return $this->formSelector;
    }

    /**
     * @param string $engine
     */
    public function setTemplateEngine($engine = null)
    {
        $this->templateEngine = $engine;

        return $this;
    }

    public function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    /**
     * @param string $tpl
     */
    public function setTemplate($tpl = null)
    {
        $this->template = $tpl;

        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTimeToLive($ttl = 120)
    {
        $this->timeToLive = (int)$ttl;

        return $this;
    }

    public function getTimeToLive()
    {
        return (int)$this->timeToLive;
    }

    public function setLimit($limit = 12)
    {
        $this->limit = (int)$limit;

        return $this;
    }

    public function getLimit() {
        return (int)$this->limit;
    }

    public function setCache($boolean = true)
    {
        $this->cache = (boolean)$boolean;

        return $this;
    }

    public function getCache() {
        return (boolean)$this->cache;
    }

    public function setSearchPath($search_path)
    {
        $this->searchPath = $search_path;

        return $this;
    }

    public function getSearchPath()
    {
        return $this->searchPath;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $engine = $this
            ->getContainer()
            ->get('templating')
        ;

        $out = $engine->render(
            'ScribeSharedBundle:Search:typeahead.js.twig',
            [
                'search' => $this
            ]
        );

        return $out;
    }
}
