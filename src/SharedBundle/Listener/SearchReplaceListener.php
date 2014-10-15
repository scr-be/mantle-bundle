<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * SearchReplaceListener
 * handles accepting newsletter signup posts from any page
 */
class SearchReplaceListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface|null
     */
    private $container = null;

    /**
     * @param $container ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * @param $container ContainerInterface
     * @return $this
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $content  = $response->getContent();

        $em = $this
            ->container
            ->get('doctrine.orm.default_entity_manager')
        ;

        $repo  = $em->getRepository('ScribeSharedBundle:ResponseSearchReplace');
        $items = $repo->findAll();

        foreach ($items as $i) {
            if ($i->getRe() === true) {
                $content = preg_replace('#'.$i->getK().'#', $i->getV(), $content);
            } else {
                $content = str_replace($i->getK(), $i->getV(), $content);
            }
        }

        $response->setContent($content);
    }
}
