<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\HttpFoundation\Request;
use Scribe\MantleBundle\Entity\NewsletterUser;
use Swift_Message;

/**
 * handles accepting newsletter signup posts from any page.
 */
class NewsletterListener implements ContainerAwareInterface
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
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param $event FilterControllerEvent
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $this
            ->container
            ->get('request')
        ;

        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ProfilerController) {
            return;
        }

        if ($request->isMethod('POST')) {
            $this->handleNewsletterPost($request, $event);
        }
    }

    /**
     * @param $event FilterControllerEvent
     */
    private function handleNewsletterPost(Request $request, FilterControllerEvent $event)
    {
        $email = $request
            ->request
            ->get('_newsletter_signup_email')
        ;

        if ($email === null || empty(trim($email))) {
            return;
        }

        $em = $this
            ->container
            ->get('doctrine.orm.default_entity_manager')
        ;

        $session = $request
            ->getSession()
        ;

        $users = $em
            ->getRepository('ScribeMantleBundle:NewsletterUser')
            ->findByEmail($email)
        ;

        if (count($users) !== 0) {
            $session
                ->getFlashBag()
                ->add('info', 'You are already signed up for the Scribe newsletter.')
            ;
        } else {
            $user = new NewsletterUser();
            $user->setEmail($email);

            $em->persist($user);
            $em->flush();

            $this->emailNotification($request, $user);

            $session
                ->getFlashBag()
                ->add('success', 'You have been signed up for the Scribe newsletter.')
            ;
        }
    }

    /**
     * @param $user NewsletterUser
     */
    private function emailNotification(Request $request, NewsletterUser $user)
    {
        $hostLink = $request
            ->getSchemeAndHttpHost()
        ;

        $view = $this
            ->container
            ->get('templating')
            ->render(
                'ScribeMantleBundle:Mail:newsletter-signup.html.twig',
                [
                    'u' => $user,
                    'host_link' => $hostLink,
                ]
            )
        ;

        $message = Swift_Message::newInstance()
            ->setSubject('Scribe: Newsletter Signup')
            ->setFrom(['accounts@scribenet.com' => 'Scribe World'])
            ->setTo([
                'drech@scribenet.com' => 'David Alan Rech',
                'sushioda@scribenet.com' => 'Steve Ushioda',
                'rfrawley@scribenet.com' => 'Rob M Frawley',
            ])
            ->setReplyTo([$user->getEmail()])
            ->setBody($view, 'text/html')
        ;

        $this
            ->container
            ->get('mailer')
            ->send($message)
        ;
    }
}

/* EOF */
