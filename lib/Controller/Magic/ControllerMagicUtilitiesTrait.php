<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Controller\Magic;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Exception\ORMException;
use Scribe\Doctrine\Exception\TransactionORMException;
use Scribe\Utility\Caller\Call;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerParameterException;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException;

/**
 * Class ControllerMagicUtilities.
 */
trait ControllerMagicUtilitiesTrait
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return ContainerInterface
     */
    public function container()
    {
        return $this->container;
    }

    /**
     * Provides an array of services corresponding to the array of service IDs provided as parameters.
     *
     * @param string,... $id An array of service IDs to resolve from the container.
     *
     * @return mixed[]
     */
    public function getServiceCollection(...$id)
    {
        $services = [];

        foreach ($id as $serviceId) {
            $services[(string) $serviceId] = $this->getService($serviceId);
        }

        return (array) $services;
    }

    /**
     * Provides a service definition based on the service ID provided.
     *
     * @param string $id A service key to resolve from the container
     *
     * @throws InvalidContainerServiceException
     *
     * @return mixed
     */
    public function getService($id)
    {
        if (true === $this->hasService($id)) {
            return $this->container->get($id);
        }

        throw InvalidContainerServiceException::getDefaultInstance($id);
    }

    /**
     * Check if a service exists within the container.
     *
     * @param string $id A service key to search for within the container.
     *
     * @return mixed
     */
    public function hasService($id)
    {
        return (bool) ($this->container->has($id) === true ?: false);
    }

    /**
     * Provides an array of parameters corresponding to an array of parameter keys provided as method arguments.
     *
     * @param string,... $id The parameter keys to resolve.
     *
     * @return mixed
     */
    public function getParameterCollection(...$id)
    {
        $parameters = [];

        foreach ($id as $parameterId) {
            $parameters[(string) $parameterId] = $this->getParameter($id);
        }

        return (array) $parameters;
    }

    /**
     * Provides a parameter value based on the key provided.
     *
     * @param string $id A parameter key to resolve.
     *
     * @throws InvalidContainerParameterException
     *
     * @return mixed
     */
    public function getParameter($id)
    {
        if (true === $this->hasParameter($id)) {
            return $this->container->getParameter($id);
        }

        throw InvalidContainerParameterException::getDefaultInstance($id);
    }

    /**
     * Checks if a parameter exists within the container.
     *
     * @param string $id A parameter key to check for within the container.
     *
     * @return bool
     */
    public function hasParameter($id)
    {
        return (bool) ($this->container->hasParameter($id) === true ?: false);
    }

    /**
     * Access the entity manager quickly through this short hand method.
     *
     * @param string|null $id The id of the EM service if not the default.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function em($id = null)
    {
        return $this->getService(
            $id !== null ? $id : ControllerMagicUtilitiesInterface::EM_DEFAULT_ID
        );
    }

    /**
     * Flush the pending ORM change-set to the DB.
     *
     * @param bool $now Should the change-set be flushed?
     *
     * @return $this
     */
    public function emFlush($now = true)
    {
        if (true === $now) {
            $this->em()->flush();
        }

        return $this;
    }

    /**
     * Begin a transaction.
     *
     * @return $this
     */
    public function emTransactionBegin()
    {
        $this->em()->beginTransaction();

        return $this;
    }

    /**
     * Commit a transaction.
     *
     * @return $this
     */
    public function emTransactionCommit()
    {
        $this->em()->commit();

        return $this;
    }

    /**
     * Rollback a transaction.
     *
     * @return $this
     */
    public function emTransactionRollback()
    {
        $this->em()->rollback();

        return $this;
    }

    /**
     * Persist an array collection of entities to the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionPersist(ArrayCollection $collection, $flush = false)
    {
        return $this->entityCollectionAction('entityPersist', $collection, $flush);
    }

    /**
     * Remove an array collection of entities from the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionRemove(ArrayCollection $collection, $flush = false)
    {
        return $this->entityCollectionAction('entityRemove', $collection, $flush);
    }

    /**
     * Refresh an array collection of entities. This removes any local changes and
     * brings the entities in-line with the state of the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionRefresh(ArrayCollection $collection, $flush = false)
    {
        return $this->entityCollectionAction('entityRefresh', $collection, $flush);
    }

    /**
     * Call an instance method on elements of an array collection.
     *
     * @internal
     *
     * @param string          $method
     * @param ArrayCollection $collection
     * @param bool            $flush
     * @param bool            $filter
     *
     * @throws TransactionORMException
     *
     * @return $this
     */
    public function entityCollectionAction($method, ArrayCollection $collection, $flush = false, $filter = true)
    {
        $collection = $this->entityCollectionFilter($collection);

        try {
            $this->emTransactionBegin();

            foreach ($collection as $entity) {
                Call::method($this, $method, $entity, false);
            }

            $this->emFlush($flush);
            $this->emTransactionCommit();

        } catch (\Exception $e) {
            $this->emTransactionRollback();

            throw TransactionORMException::getDefaultInstance($e->getMessage());
        }

        return $this;
    }

    /**
     * Filter a collection to ensure they all extend AbstractEntity.
     *
     * @internal
     *
     * @param ArrayCollection $collection A collection of entities.
     *
     * @return ArrayCollection
     */
    public function entityCollectionFilter(ArrayCollection $collection)
    {
        return $collection->filter(function($entity) {
            return (bool) ($entity instanceof AbstractEntity);
        });
    }

    /**
     * Persist an entity to the database.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change-set immediately or not.
     *
     * @return $this
     */
    public function entityPersist(AbstractEntity $entity, $flush = false)
    {
        return $this->entityAction('persist', $entity, $flush);
    }

    /**
     * Remove an orm entity and optionally flush the transaction.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change-set immediately or not.
     *
     * @return $this
     */
    public function entityRemove(AbstractEntity $entity, $flush = false)
    {
        return $this->entityAction('remove', $entity, $flush);
    }

    /**
     * Refreshes an entity, discarding local changes and bringing its state in-line with
     * that of the database.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityRefresh(AbstractEntity $entity)
    {
        return $this->entityAction('refresh', $entity, false);
    }

    /**
     * Clears the entity from Doctrine's entity map. This ensures you receive a new object instance
     * when re-requesting the entity.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityClear(AbstractEntity $entity)
    {
        return $this->entityAction('clear', $entity, false);
    }

    /**
     * Detaches an entity from the manager. Any unfinished/pending changes to the entity will not
     * be persisted!
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityDetach(AbstractEntity $entity)
    {
        $this->em()->detach($entity);

        return $this;
    }

    /**
     * Re-attaches (merges) an entity back into the manager and returns the managed version of the
     * entity. The passed version of the entity remains un-managed.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return AbstractEntity
     */
    public function entityAttach(AbstractEntity $entity)
    {
        return $this->em()->merge($entity);
    }

    /**
     * Returns a new copy of the passed entity that is by default shallow-copied. A deep copy will
     * recursively copy the passed entities associations as well.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $deep   Determines if deep copy is performed (associated entities are copied).
     *
     * @return AbstractEntity
     */
    public function entityCopy(AbstractEntity $entity, $deep = false)
    {
        return $this->em()->copy($entity, (bool) $deep);
    }

    /**
     * Perform an action on an entity.
     *
     * @internal
     *
     * @param string         $method The method to call on the entity manager.
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Should the manager flush the change-set after performing this action?
     *
     * @return $this
     */
    private function entityAction($method, AbstractEntity $entity, $flush)
    {
        Call::method($this->em(), $method, $entity);
        $this->emFlush($flush);

        return $this;
    }

    /**
     * Access the templating engine service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    public function templating()
    {
        return $this->getService('templating');
    }

    /**
     * Access the Twig environment service.
     *
     * @return \Twig_Environment
     */
    public function twig()
    {
        return $this->getService('twig');
    }

    /**
     * Renders a template from a file, resolved based on the value of the template parameter.
     *
     * @param string  $templateName The template file to render.
     * @param mixed[] $parameters   An array of parameters passed to the template.
     *
     * @return string
     */
    public function renderTwigTpl($templateName, ...$parameters)
    {
        return $this
            ->templating()
            ->render($templateName, ...$parameters)
        ;
    }

    /**
     * Renders a template from the provided string.
     *
     * @param string  $templateString The template file to render.
     * @param mixed[] $parameters     An array of parameters passed to the template.
     *
     * @return string
     */
    public function renderTwigStr($templateString, ...$parameters)
    {
        return $this
            ->twig()
            ->createTemplate($templateString)
            ->render($parameters)
        ;
    }

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param array         $headers Any headers to send with the request.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse($content, array $headers = [], $status = null, callable $config = null)
    {
        $response = $this->getService('s.mantle.response.type_html');

        if (false === empty($headers)) {
            foreach($headers as $name => $value) {
                $response->addHeader([$name => $value]);
            }
        }

        if (false === empty($content)) {
            $response->setContent($content);
        }

        if (false === empty($status)) {
            $response->setStatusCode($status);
        }

        if ($config instanceof \Closure) {
            $response = $config($response);
        }

        return $response;
    }

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance.
     * {@see self::getResponse()}
     *
     * @param string        $content The content for the response.
     * @param array         $headers Any headers to send with the request.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseTypeHTML($content, array $headers = [], $status = null, callable $config = null)
    {
        return $this->getResponse($content, $headers, $status, $config);
    }

    /**
     * Create a not found exception with option to throw.
     *
     * @param string    $message           exception error message
     * @param Exception $previousException an optional previous exception (for casacading catches)
     *
     * @return NotFoundHttpException
     */
    public function createNotFoundException($message = 'Not Found', Exception $previousException = null)
    {
        return new NotFoundHttpException($message, $previousException);
    }

    /**
     * Renders a template view.
     *
     * @param string $view       The path to the template view
     * @param array  $parameters An array of paramiters to pass to the template renderer
     *
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
     * Return a response object from the provided string.
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function response($string = '', $status = 200, array $headers = [])
    {
        return new Response($string, $status, $headers);
    }

    /**
     * Return a response object from the provided string as plain text.
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function plainTextResponse($string = '', $status = 200, array $headers = [])
    {
        $headers['Content-Type'] = 'text/plain';

        return $this->response($string, $status, $headers);
    }

    /**
     * Return a response object from the provided string, alias for {@see htmlResponse}.
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function returnResponse($string = '', $status = 200, array $headers = [])
    {
        return $this->response($string, $status, $headers);
    }

    /**
     * Return a response object from the generated view.
     *
     * @param string $view       The path to the template view
     * @param array  $parameters An array of paramiters to pass to the template renderer
     *
     * @return Response
     */
    public function renderResponse($view, array $parameters = [])
    {
        return $this->response($this->renderView($view, $parameters));
    }

    /**
     * return redirect response from a provided symfony route and its (optional) arguments.
     *
     * @param string $uri     uri to redirect to
     * @param int    $status  http status code to return
     * @param array  $headers additional headers to return
     *
     * @return RedirectResponse
     */
    public function redirectResponse($uri, $status = 302, array $headers = [])
    {
        return new RedirectResponse($uri, $status, $headers);
    }

    /**
     * return redirect response from a provided symfony route and its (optional) arguments.
     *
     * @param string $routeName      name of the symfony route
     * @param array  $routeArguments optional arguments array for route
     * @param int    $status         http status code to return
     * @param array  $headers        additional headers to return
     *
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
     * Return JSON response object instance.
     *
     * @param array  $data     JSON data to return
     * @param int    $status   HTTP status code
     * @param array  $headers  Additional HTTP headers to return with response
     * @param string $protocol HTTP protocol to use
     *
     * @return JsonResponse
     */
    public function jsonResponse(array $data = null, $status = Response::HTTP_OK, array $headers = null, $protocol = '1.1')
    {
        $response = (new JsonResponse($data))
            ->setProtocolVersion($protocol)
            ->setDate(new \DateTime(null, new \DateTimeZone('UTC')))
        ;

        if (is_array($status)) {
            $response->setStatusCode(reset($status), key($status));
        } else {
            $response->setStatusCode($status);
        }

        if (is_array($headers)) {
            $response->headers->add($headers);
        }

        return $response;
    }

    /**
     * Generate a url from a routename and route args.
     *
     * @param string $route         route name
     * @param array  $parameters    route parameters
     * @param string $referenceType the url reference type
     *
     * @return string
     */
    public function generateUrl($route, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
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
     * Create a form.
     *
     * @param FormTypeInterface|null $type    form type to create
     * @param mixed                  $data    form data
     * @param array                  $options form options
     *
     * @return Form
     */
    public function createForm($type, $data = null, array $options = [])
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
     * Create a named form.
     *
     * @param string                 $name    name for the form
     * @param FormTypeInterface|null $type    form type to create
     * @param mixed                  $data    form data
     * @param array                  $options form options
     *
     * @return Form
     */
    public function createNamedForm($name, $type, $data = null, array $options = [])
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
     * @param string $type    flashbag category (type) to add message to
     * @param string $message message to display
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
     * @param string $message message to display
     */
    public function sessionMessageSuccess($message)
    {
        $this->sessionMessage('success', $message);
    }

    /**
     * Add session error message to flashbag.
     *
     * @param string $message message to display
     */
    public function sessionMessageError($message)
    {
        $this->sessionMessage('error', $message);
    }

    /**
     * Add session info to flashbag.
     *
     * @param string $message message to display
     */
    public function sessionMessageInfo($message)
    {
        $this->sessionMessage('info', $message);
    }

    /**
     * Get translation string.
     *
     * @param string $key translation index
     *
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

/* EOF */
