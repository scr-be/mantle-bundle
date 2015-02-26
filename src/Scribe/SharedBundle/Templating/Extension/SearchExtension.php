<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\SharedBundle\Templating\Helper\Search\Search;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension;

/**
 * Class SearchExtension
 */
class SearchExtension extends Twig_Extension
{
    use AdvancedExtensionTrait;

    /**
     * @var Search
     */
    private $searchHelper = null;

    /**
     * @param ContainerInterface $container
     * @param Search             $searchHelper
     */
    public function __construct(ContainerInterface $container, Search $searchHelper)
    {
        $this->searchHelper = $searchHelper;
        $this
            ->searchHelper
            ->setContainer($container)
        ;

        $this->addFunctionMethod('search',     'search');
        $this->addFunctionMethod('searchText', 'search_text' );
    }

    /**
     * @param  string $what
     * @return string
     */
    public function searchText($what = 'Bundle')
    {
        $return = '';

        $bundleInfo = $this
            ->searchHelper
            ->getBundleInfo()
        ;
        $method = 'get'.$what;

        if (method_exists($bundleInfo, $method)) {
            $return = ucwords($bundleInfo->$method());

            switch($return) {
                case 'Eep':
                    $return = 'E-book Project';
                    break;
                case 'Digitalhub':
                    $return = 'Digital Hub';
                    break;
                case 'Public':
                    $return = 'Scribe';
                    break;
            }
        }

        return $return;
    }

    /**
     * @return mixed
     */
    public function search($search_path)
    {
        $this
            ->searchHelper
            ->setSearchPath($search_path)
        ;

        return $this->searchHelper->render();
    }
}
