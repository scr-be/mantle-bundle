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

use Scribe\Component\DependencyInjection\Aware\RequestAwareTrait;
use Swift_Message;
use Scribe\Component\DependencyInjection\Aware\ServiceContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\HttpFoundation\Request;

/**
 * handles accepting newsletter signup posts from any page.
 */
class NewsletterListener
{
    use ServiceContainerAwareTrait,
        RequestAwareTrait;

    /**
     * @param $container ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setServiceContainer($container);
        $this->setRequestFromContainer($container);
    }

    /**
     * @param $event FilterControllerEvent
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $this
            ->serviceContainer
            ->get('request')
        ;

        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ProfilerController) {
            return;
        }

        if ($this->getRequest()->isMethod('POST')) {
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
            ->serviceContainer
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
            $session
                ->getFlashBag()
                ->add('success', 'An error occured while trying to sign you up for the Scribe newsletter.')
            ;

            return;

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
