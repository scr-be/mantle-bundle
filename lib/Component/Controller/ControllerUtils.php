<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller;

use Exception;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Scribe\SharedBundle\Entity\Interfaces\EntityInterface;
use Scribe\DependencyInjection\ContainerAwareTrait;
use Scribe\SharedBundle\Utility\Exception\InvalidArgumentException;

/**
 * Class ControllerUtils
 *
 * @package Scribe\Component\Controller
 */
class ControllerUtils implements ControllerUtilsInterface, ContainerAwareInterface
{
    /**
     * Import container aware property and methods
     */
    use ContainerAwareTrait;

    /**
     * Handle setting up the object instance
     *
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * Get an array of container services by passing a list of services to fetch
     *
     * @param  string,... $serviceKeys the container service keys to get
     * @return array
     */
    public function getServices(...$serviceKeys)
    {
        $services = [];

        foreach ($serviceKeys as $key) {
            $services[] = $this->getService($key);
        }

        return $services;
    }

    /**
     * Get a single container service by passing the service key
     *
     * @param  string $serviceKey the container service key to get
     * @return mixed
     */
    public function getService($serviceKey)
    {
        return $this->getServiceHelper($serviceKey);
    }

    /**
     * Get a container service with available helper shortcut keys
     *
     * @param  string $serviceKey the container service key to get
     * @return object
     */
    private function getServiceHelper($serviceKey)
    {
        switch ($serviceKey) {
            case 'em':
                return $this
                    ->getContainer()
                    ->get('doctrine')
                    ->getManager()
                ;
            case 'session':
                return $this
                    ->getContainer()
                    ->get('request')
                    ->getSession()
                ;
            case 'user':
                return $this
                    ->getContainer()
                    ->get('security.context')
                    ->getToken()
                    ->getUser()
                ;
            case 'security':
                return $this
                    ->getContainer()
                    ->get('security.context')
                ;
            default:
                return $this
                    ->getContainer()
                    ->get($serviceKey)
                ;
        }
    }

    /**
     * Set container peramiter value
     *
     * @param  string $key parameter reference key to check for
     * @return bool
     */
    public function hasParameter($key)
    {
        return (bool)$this
            ->getContainer()
            ->hasParameter($key)
        ;
    }

    /**
     * Get container perameter value
     *
     * @param  string $key key reference to parameter
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this
            ->getContainer()
            ->getParameter($key)
        ;
    }

    /**
     * Flush the orm entity to the database
     *
     * @param  bool $flushNow should this action actually take place now?
     * @return bool
     */
    public function entityManagerFlush($flushNow = true)
    {
        if ($flushNow !== true) {
            return false;
        }

        return (bool)$this
            ->getService('em')
            ->flush()
        ;
    }

    /**
     * Persist an orm entity and optionally flush the transaction
     *
     * @param  EntityInterface $entity   an orm entity instance
     * @param  bool            $flushNow whether to flush transaction
     * @return bool
     */
    public function entityPersist(EntityInterface $entity, $flushNow = true)
    {
        return $this->entityAction('persist', $entity, $flushNow);
    }

    /**
     * Remove an orm entity and optionally flush the transaction
     *
     * @param  EntityInterface $entity   an orm entity instance
     * @param  bool            $flushNow whether to flush transaction
     * @return bool
     */
    public function entityRemove(EntityInterface $entity, $flushNow = true)
    {
        return $this->entityAction('remove', $entity, $flushNow);
    }

    /**
     * Perform an orm entity action and optionally flush the transaction
     *
     * @param  string          $action entity action to perform
     * @param  EntityInterface $entity an orm entity instance
     * @param  bool            $flushNow  whether to flush transaction
     * @return bool
     */
    private function entityAction($action, EntityInterface $entity, $flushNow = true)
    {
        if (!in_array($action, ['remove', 'persist'])) {
            throw new RuntimeException('Invalud entity action ' . $action);
        }

        if (false === ($result = $this->getService('em')->$action($entity))) {
            return false;
        }

        $this->entityManagerFlush($flushNow);

        return (bool)$result;
    }

    /**
     * Create a not found exception with option to throw
     *
     * @param  string    $message           exception error message
     * @param  Exception $previousException an optional previous exception (for casacading catches)
     * @return NotFoundHttpException
     */
    public function createNotFoundException($message = 'Not Found', Exception $previousException = null)
    {
        return new NotFoundHttpException($message, $previousException);
    }

    /**
     * Renders a template view
     *
     * @param  string $view       The path to the template view
     * @param  array  $parameters An array of paramiters to pass to the template renderer
     * @return string
     */
    public function renderView($view, array $parameters = [])
    {
        return $this
            ->getService('templating')
            ->render(
                $view,
                $parameters
            )
        ;
    }

    /**
     * Return a response object from the provided string
     *
     * @param  string $string  A string value to return as the response
     * @param  int    $status  HTTP status code to return
     * @param  array  $headers Additional headers to return
     * @return Response
     */
    public function response($string = '', $status = 200, array $headers = [])
    {
        return new Response($string, $status, $headers);
    }

    /**
     * Return a response object from the provided string as plain text
     *
     * @param  string $string A string value to return as the response
     * @param  int    $status  HTTP status code to return
     * @param  array  $headers Additional headers to return
     * @return Response
     */
    public function plainTextResponse($string = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'text/plain';

        return $this->response($string, $status, $headers);
    }

    /**
     * Return a response object from the provided string, alias for {@see htmlResponse}
     *
     * @param  string $string A string value to return as the response
     * @param  int    $status  HTTP status code to return
     * @param  array  $headers Additional headers to return
     * @return Response
     */
    public function returnResponse($string = '', $status = 200, array $headers = [])
    {
        return $this->response($string, $status, $headers);
    }

    /**
     * Return a response object from the generated view
     *
     * @param  string $view       The path to the template view
     * @param  array  $parameters An array of paramiters to pass to the template renderer
     * @return Response
     */
    public function renderResponse($view, array $parameters = [])
    {
        return $this->response($this->renderView($view, $parameters));
    }

    /**
     * return redirect response from a provided symfony route and its (optional) arguments
     *
     * @param  string $uri      uri to redirect to
     * @param  int    $status   http status code to return
     * @param  array  $headers  additional headers to return
     * @return RedirectResponse
     */
    public function redirectResponse($uri, $status = 302, array $headers = [])
    {
        return new RedirectResponse($uri, $status, $headers);
    }

    /**
     * return redirect response from a provided symfony route and its (optional) arguments
     *
     * @param  string $routeName      name of the symfony route
     * @param  array  $routeArguments optional arguments array for route
     * @param  int    $status         http status code to return
     * @param  array  $headers        additional headers to return
     * @return RedirectResponse
     */
    public function routeRedirectResponse($routeName, array $routeArguments = [], $status = 302, array $headers = [])
    {
        return $this->redirectResponse(
            $this->generateUrl($routeName, $routeArguments),
            $status,
            $headers
        );
    }

    /**
     * Return JSON response object instance
     *
     * @param  array  $data     JSON data to return
     * @param  int    $status   HTTP status code
     * @param  array  $headers  Additional HTTP headers to return with response
     * @param  string $protocol HTTP protocol to use
     * @return JsonResponse
     */
    public function jsonResponse(array $data = null, $status = Response::HTTP_OK, array $headers = null, $protocol = '1.1')
    {
        $response = (new JsonResponse)
            ->setContent($data)
            ->setProtocolVersion($protocol)
            ->setDate(new \DateTime(null, new \DateTimeZone('UTC')))
        ;

        if (is_array($status)) {
            $response->setStatus(reset($status), key($status));
        }
        else {
            $response->setStatus($status);
        }

        if (is_array($headers)) {
            $response->headers->add($headers);
        }

        return $response;
    }

    /**
     * Generate a url from a routename and route args
     *
     * @param  string $route         route name
     * @param  array  $parameters    route parameters
     * @param  string $referenceType the url reference type
     * @return string
     */
    public function generateUrl($route, array $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this
            ->getService('router')
            ->generate(
                $route,
                $parameters,
                $referenceType
            )
        ;
    }

    /**
     * Create a form
     *
     * @param  FormTypeInterface|null $type    form type to create
     * @param  mixed                  $data    form data
     * @param  array                  $options form options
     * @return Form
     */
    public function createForm($type, $data = null, array $options = array())
    {
        return $this
            ->getService('form.factory')
            ->create(
                $type,
                $data,
                $options
            )
        ;
    }

    /**
     * Create a named form
     *
     * @param  string                 $name    name for the form
     * @param  FormTypeInterface|null $type    form type to create
     * @param  mixed                  $data    form data
     * @param  array                  $options form options
     * @return Form
     */
    public function createNamedForm($name, $type, $data = null, array $options = array())
    {
        return $this
            ->getService('form.factory')
            ->createNamed(
                $name,
                $type,
                $data,
                $options
            )
        ;
    }

    /**
     * Add session message to flashbag.
     *
     * @param  string $type    flashbag category (type) to add message to
     * @param  string $message message to display
     * @return void
     */
    public function sessionMessage($type, $message)
    {
        $this
            ->getService('session')
            ->getFlashBag()
            ->add($type, $message)
        ;
    }

    /**
     * Add session success message to flashbag.
     *
     * @param  string $message message to display
     * @return void
     */
    public function sessionMessageSuccess($message)
    {
        $this->sessionMessage('success', $message);
    }

    /**
     * Add session error message to flashbag.
     *
     * @param  string $message message to display
     * @return void
     */
    public function sessionMessageError($message)
    {
        $this->sessionMessage('error', $message);
    }

    /**
     * Add session info to flashbag.
     *
     * @param  string $message message to display
     * @return void
     */
    public function sessionMessageInfo($message)
    {
        $this->sessionMessage('info', $message);
    }

    /**
     * Get translation string.
     *
     * @param  string $key translation index
     * @return string
     */
    public function getTranslation($key)
    {
        return $this
            ->getService('translator')
            ->trans($key)
        ;
    }

    /**
     * Get the request scheme and host.
     *
     * @return string
     */
    public function getSchemeAndHost()
    {
        return $this
            ->getService('request')
            ->getSchemeAndHttpHost()
        ;
    }
}
