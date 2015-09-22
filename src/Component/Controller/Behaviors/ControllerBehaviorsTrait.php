<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Controller\Behaviors;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Scribe\MantleBundle\Component\DependencyInjection\Aware\ServiceContainerAwareTrait;
use Scribe\MantleBundle\Component\HttpFoundation\Response\Response;
use Scribe\MantleBundle\Component\HttpFoundation\Response\ResponseInterface;
use Scribe\MantleBundle\Component\Security\Core\UserInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Scribe\MantleBundle\Doctrine\Exception\ORMException;
use Scribe\MantleBundle\Doctrine\Exception\TransactionORMException;
use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Wonka\Exception\RuntimeException;
use Scribe\Wonka\Utility\Caller\Call;
use Scribe\WonkaBundle\Component\DependencyInjection\Exception\InvalidContainerParameterException;
use Scribe\WonkaBundle\Component\DependencyInjection\Exception\InvalidContainerServiceException;
use Scribe\MantleBundle\Component\Controller\Exception\ControllerException;
use Scribe\MantleBundle\Component\HttpFoundation\Exception\HttpException;
use Scribe\MantleBundle\Component\HttpFoundation\Exception\NotFoundHttpException;
use Scribe\MantleBundle\Component\HttpFoundation\Exception\UnauthorizedHttpException;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Doctrine\Entity\Route\Route;
use Scribe\MantleBundle\Templating\Generator\Node\Model\NodeCreatorInterface;

/**
 * Class ControllerBehaviorsTrait.
 */
trait ControllerBehaviorsTrait
{
    use ServiceContainerAwareTrait;

    /**
     * @return ContainerInterface
     */
    public function container()
    {
        return $this->serviceContainer;
    }

    /**
     * Provides an array of services corresponding to the array of service IDs provided as parameters.
     *
     * @param string,... $ids An array of service IDs to resolve from the container.
     *
     * @return mixed[]
     */
    public function getServiceCollection(...$ids)
    {
        $services = [];

        foreach ($ids as $serviceId) {
            if (false === is_array($serviceId)) {
                $services[(string) $serviceId] = $this->getService($serviceId);
                continue;
            }

            $services = array_merge(
                $services,
                $this->getServiceCollection(...$serviceId)
            );
        }

        return (array) $services;
    }

    /**
     * Provides a service definition based on the service ID provided.
     *
     * @param string $id A service key to resolve from the container
     *
     * @throws InvalidContainerServiceException|\Exception
     *
     * @return mixed
     */
    public function getService($id)
    {
        if (true === $this->hasService($id)) {
            return $this->serviceContainer->get($id);
        }

        throw $this->processException(
            new InvalidContainerServiceException(null, null, null, $id)
        );
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
        return (bool) ($this->serviceContainer->has($id) === true ?: false);
    }

    /**
     * Provides an array of parameters corresponding to an array of parameter keys provided as method arguments.
     *
     * @param string,... $ids The parameter keys to resolve.
     *
     * @return mixed
     */
    public function getParameterCollection(...$ids)
    {
        $parameters = [];

        foreach ($ids as $parameterId) {
            if (false === is_array($parameterId)) {
                $parameters[(string) $parameterId] = $this->getParameter($parameterId);
                continue;
            }

            $parameters = array_merge(
                $parameters,
                $this->getParameterCollection(...$parameterId)
            );
        }

        return (array) $parameters;
    }

    /**
     * Provides a parameter value based on the key provided.
     *
     * @param string $id A parameter key to resolve.
     *
     * @throws InvalidContainerParameterException|\Exception
     *
     * @return mixed
     */
    public function getParameter($id)
    {
        if (true === $this->hasParameter($id)) {
            return $this->serviceContainer->getParameter($id);
        }

        throw $this->processException(
            new InvalidContainerParameterException(null, null, null,  $id)
        );
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
        return (bool) ($this->serviceContainer->hasParameter($id) === true ?: false);
    }

    /**
     * Get the doctrine registry service.
     *
     * @return Registry
     */
    public function doctrine()
    {
        return $this->getService('doctrine');
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
        return $this->getService($id ?: ControllerBehaviorsInterface::EM_DEFAULT_ID);
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
     * @throws \Exception
     *
     * @return $this
     */
    public function entityCollectionAction($method, ArrayCollection $collection, $flush = false, $filter = true)
    {
        $collection = $filter === true ? $this->entityCollectionFilter($collection) : $collection;

        try {
            $this->emTransactionBegin();

            foreach ($collection as $entity) {
                Call::method($this, $method, $entity, false);
            }

            $this->emFlush($flush);
            $this->emTransactionCommit();
            if ($flush === true) {
                $this->emFlush();
            }
        } catch (\Exception $e) {
            $this->emTransactionRollback();

            throw $this->processException(new TransactionORMException(
                null, null, $e, $e->getMessage()
            ));
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
        return $collection->filter(function ($entity) {
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
     * @param string         $method
     * @param AbstractEntity $entity
     * @param bool           $flush
     *
     * @internal
     *
     * @throws \Exception
     *
     * @return $this
     */
    private function entityAction($method, AbstractEntity $entity, $flush)
    {
        try {
            Call::method($this->em(), (string) $method, $entity);
            $this->emFlush($flush);
        } catch (\Exception $e) {
            throw $this->processException(new ORMException(null, null, $e, $e->getMessage()));
        }

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
    public function renderTwigTpl($templateName, array $parameters = [])
    {
        return $this
            ->templating()
            ->render($templateName, $parameters)
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
    public function renderTwigStr($templateString, array $parameters = [])
    {
        return $this
            ->twig()
            ->createTemplate($templateString)
            ->render($parameters)
        ;
    }

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance. This is aimply
     * an alias for {@see $this->getResponseTypeHtml()}.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param array         $headers Any headers to send with the request.
     *
     * @return Response
     */
    public function getResponse($content, callable $config = null, $status = null, array $headers = [])
    {
        return $this->getResponseTypeHtml($content, $config, $status, $headers);
    }

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param array         $headers Any headers to send with the request.
     *
     * @return Response
     */
    public function getResponseTypeHtml($content, callable $config = null, $status = null, array $headers = [])
    {
        $response = $this->getService('s.mantle.response.type_html');

        return $this->readyResponse($response, $content, $config, $status, $headers);
    }

    /**
     * Returns a plaintext response using the provided parameters to construct the Response object instance.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param array         $headers Any headers to send with the request.
     *
     * @return Response
     */
    public function getResponseTypeText($content, callable $config = null, $status = null, array $headers = [])
    {
        $response = $this->getService('s.mantle.response.type_text');

        return $this->readyResponse($response, $content, $config, $status, $headers);
    }

    /**
     * Returns a json response using the provided parameters to construct the Response object instance.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param array         $headers Any headers to send with the request.
     *
     * @return Response
     */
    public function getResponseTypeJson($content, callable $config = null, $status = null, array $headers = [])
    {
        $response = $this->getService('s.mantle.response.type_json');

        return $this->readyResponse($response, $content, $config, $status, $headers);
    }

    /**
     * Returns a plaintext response using the provided parameters to construct the Response object instance.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html}.
     *
     * @param string        $content The content for the response.
     * @param callable|null $config  A callable that should expect a single parameter of type Request, which is passed
     *                               after the Request object has been instantiated and configured using the previous
     *                               parameters specified. The callable must return a response object (with no
     *                               requirement it is the same response object passed to it). If it does not return
     *                               a Response an error will be raised.
     * @param array|int     $status  Either an integer specifying the HTTP response code or a single array element with
     *                               its index representing the HTTP response code and the value representing the
     *                               response status text description.
     * @param array         $headers Any headers to send with the request.
     *
     * @return Response
     */
    public function getResponseTypeYaml($content, callable $config = null, $status = null, array $headers = [])
    {
        $response = $this->getService('s.mantle.response.type_yaml');

        return $this->readyResponse($response, $content, $config, $status, $headers);
    }

    /**
     * @param ResponseInterface $response The response object.
     * @param string            $content  The content for the response.
     * @param array             $headers  Any headers to send with the request.
     * @param array|int         $status   Either an integer specifying the HTTP response code or a single array element with
     *                                    its index representing the HTTP response code and the value representing the
     *                                    response status text description.
     * @param callable|null     $config   A callable that should expect a single parameter of type Request, which is passed
     *                                    after the Request object has been instantiated and configured using the previous
     *                                    parameters specified. The callable must return a response object (with no
     *                                    requirement it is the same response object passed to it). If it does not return
     *                                    a Response an error will be raised.
     *
     * @internal
     *
     * @return Response
     */
    public function readyResponse(ResponseInterface $response, $content = null, callable $config = null, $status = null, array $headers = [])
    {
        foreach ($headers as $name => $value) {
            $response->addHeader($name, $value);
        }

        if ($content !== null && is_scalar($content)) {
            $response->setContent($content);
        }

        if ($content !== null && is_array($content)) {
            $response->setData($content);
        }

        if ($status !== null) {
            $response->setStatusCode($status);
        }

        if ($config instanceof \Closure && ($configuredResponse = $config($response)) instanceof Response) {
            $response = $configuredResponse;
        }

        return $response;
    }

    /**
     * @param               $name
     * @param array         $arguments
     * @param callable|null $config    A callable that should expect a single parameter of type Request, which is passed
     *                                 after the Request object has been instantiated and configured using the previous
     *                                 parameters specified. The callable must return a response object (with no
     *                                 requirement it is the same response object passed to it). If it does not return
     *                                 a Response an error will be raised.
     * @param array         $headers   Any headers to send with the request.
     * @param array|int     $status    Either an integer specifying the HTTP response code or a single array element with
     *                                 its index representing the HTTP response code and the value representing the
     *                                 response status text description.
     *
     * @return mixed
     */
    public function getResponseTypeHTMLRenderedByTwig($name, array $arguments = [], callable $config = null, array $headers = [], $status = null)
    {
        $content = $this->twig()->render($name, $arguments);

        return $this->getResponse($content, $config, $status, $headers);
    }

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirect($uri, $status = 302)
    {
        return new RedirectResponse($uri, $status);
    }

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByUri($uri, $status = 302)
    {
        return $this->getResponseRedirect($uri, $status);
    }

    /**
     * Returns a RedirectResponse configured based on the provided URL.
     *
     * @param string $url
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByUrl($url, $status = 302)
    {
        return $this->getResponseRedirect($url, $status);
    }

    /**
     * Returns a RedirectResponse configured based on the passed Route entity provided.
     *
     * @param Route $route
     * @param int   $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByRouteEntity(Route $route, $status = 302)
    {
        $this->getResponseRedirect(
            $this->getRouteUri($route->getName(), $route->getParameters()), $status
        );
    }

    /**
     * Returns a RedirectResponse based on a route.
     *
     * @param string $routePath
     * @param array  $routeParameters
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByRouterKey($routePath, array $routeParameters = [], $status = 302)
    {
        return new RedirectResponse(
            $this->getRouteUri($routePath, $routeParameters), $status
        );
    }

    /**
     * Provides the router service from the container.
     *
     * @return RouterInterface
     */
    public function router()
    {
        return $this->getService('router');
    }

    /**
     * Uses the Router service to create a URI based on the route key and parameters provided.
     *
     * @param string  $key
     * @param mixed[] $parameters
     *
     * @return string
     */
    public function getRouteUri($key, array $parameters = [])
    {
        return $this
            ->router()
            ->generate($key, $parameters, RouterInterface::RELATIVE_PATH)
        ;
    }

    /**
     * Uses the Router service to create a URL based on the route key and parameters provided.
     *
     * @param string  $key
     * @param mixed[] $parameters
     *
     * @return string
     */
    public function getRouteUrl($key, array $parameters = [])
    {
        return $this
            ->router()
            ->generate($key, $parameters, RouterInterface::ABSOLUTE_URL)
        ;
    }

    /**
     * Accepts any exception extending AbstractHttpException and returns the same exception populated with a
     * collection of additional debugging attributes. The intended use is to throw the return value of this
     * function (versus simply throwing the exception itself); by wrapping the exception in this method, it
     * intelligently handles providing the exception with request-specific information.
     *
     * @param \Exception $exception
     *
     * @return \Exception
     */
    public function processException(\Exception $exception)
    {
        return $exception;
    }

    /**
     * Creates and returns a generic http exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionGeneric($message = null, ...$sprintfArgs)
    {
        return $this->processException(new HttpException($message, null, null, ...$sprintfArgs));
    }

    /**
     * Creates and returns a not found exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionNotFound($message = null, ...$sprintfArgs)
    {
        return $this->processException(new NotFoundHttpException($message, $sprintfArgs));
    }

    /**
     * Creates and returns an unauthorized exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionUnauthorized($message = null, ...$sprintfArgs)
    {
        return $this->processException(new UnauthorizedHttpException($message, $sprintfArgs));
    }

    /**
     * Returns the session service from the container.
     *
     * @return Session
     */
    public function session()
    {
        return $this->getService('session');
    }

    /**
     * Add a flash message to the session of type "info" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfo($message, ...$sprintfArgs)
    {
        return $this->addSessionMsg(ControllerBehaviorsInterface::SESSION_MSG_INFO, $message, ...$sprintfArgs);
    }

    /**
     * Add a flash message to the session of type "info" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfoByTrans($translationKey, ...$sprintfArgs)
    {
        return $this->addSessionMsgInfo($this->translator()->trans($translationKey), ...$sprintfArgs);
    }

    /**
     * Add a flash message to the session of type "success" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccess($message, ...$sprintfArgs)
    {
        return $this->addSessionMsg(ControllerBehaviorsInterface::SESSION_MSG_SUCCESS, $message, ...$sprintfArgs);
    }

    /**
     * Add a flash message to the session of type "success" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccessByTrans($translationKey, ...$sprintfArgs)
    {
        return $this->addSessionMsgSuccess($this->translator()->trans($translationKey), ...$sprintfArgs);
    }

    /**
     * Add a flash message to the session of type "error" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgError($message, ...$sprintfArgs)
    {
        return $this->addSessionMsg(ControllerBehaviorsInterface::SESSION_MSG_ERROR, $message, ...$sprintfArgs
        );
    }

    /**
     * Add a flash message to the session of type "error" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgErrorByTrans($translationKey, ...$sprintfArgs)
    {
        return $this->addSessionMsgError($this->translator()->trans($translationKey), ...$sprintfArgs);
    }

    /**
     * Add a session message of the specified type.
     *
     * @param string    $type
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    protected function addSessionMsg($type, $message, ...$sprintfArgs)
    {
        if (count($sprintfArgs) > 0) {
            $message = sprintf($message, $sprintfArgs);
        }

        $this
            ->session()
            ->getFlashBag()
            ->add($type, $message)
        ;

        return $this;
    }

    /**
     * Provides the user token storage service from the container.
     *
     * @return TokenStorageInterface
     */
    public function tokenStorage()
    {
        return $this->getService('security.token_storage');
    }

    /**
     * Provides the user token service from the container.
     *
     * @return TokenInterface|null
     */
    public function token()
    {
        return $this->tokenStorage()->getToken();
    }

    /**
     * Provides the authorization service from the container.
     *
     * @return AuthorizationCheckerInterface
     */
    public function auth()
    {
        return $this->getService('security.authorization_checker');
    }

    /**
     * @param string,... $attributeCollection
     *
     * @return bool
     */
    public function isGranted(...$attributeCollection)
    {
        foreach ($attributeCollection as $attribute) {
            if (false === $this->auth()->isGranted($attribute)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed  $object
     *
     * @return bool
     */
    public function isGrantedFor($attribute, $object)
    {
        return (bool) $this->auth()->isGranted($attribute, $object);
    }

    /**
     * Provides the user entity for the current session, or returns null if no user is available (such as when a user
     * has not logged on).
     *
     * @throws RuntimeException
     *
     * @return UserInterface|null
     */
    public function user()
    {
        if (null === ($token = $this->token())) {
            throw new RuntimeException('Cannot request user entity when no token exists.');
        }

        if (null === ($user = $token->getUser())) {
            throw new RuntimeException('Cannot get user entity from token.');
        }

        return $user;
    }

    /**
     * Returns the translation service.
     *
     * @return TranslatorInterface
     */
    public function translator()
    {
        return $this->getService('translator');
    }

    /**
     * Resolves the string value based on a provided key.
     *
     * @param string    $key        A translation key.
     * @param mixed,... $parameters Parameters for the translation.
     *
     * @return string
     */
    public function getTranslation($key, ...$parameters)
    {
        return $this
            ->translator()
            ->trans($key, $parameters)
        ;
    }

    /**
     * Returns the request stack service.
     *
     * @return RequestStack
     */
    public function requestStack()
    {
        return $this->getService('request_stack');
    }

    /**
     * Returns the current request by querying the request stack service. Returns null if no current exists.
     *
     * @return Request|null
     */
    public function getRequestCurrent()
    {
        return $this
            ->requestStack()
            ->getCurrentRequest()
        ;
    }

    /**
     * Returns the master request by querying the request stack service. Returns null if no master request exists.
     *
     * @return Request|null
     */
    public function getRequestMaster()
    {
        return $this
            ->requestStack()
            ->getMasterRequest()
        ;
    }

    /**
     * Determines if the current request-scope is the master request.
     *
     * @return bool
     */
    public function isRequestMaster()
    {
        return (bool) ($this->requestStack()->getCurrentRequest() === $this->requestStack()->getMasterRequest());
    }

    /**
     * Returns the parent request by querying the request stack service. Returns null if no parent request exists.
     *
     * @return Request|null
     */
    public function getRequestParent()
    {
        if ($this->isRequestMaster() === true) {
            $this->processException(
                new RuntimeException('Cannot get the parent request as this is the master request.')
            );
        }

        return $this
            ->requestStack()
            ->getParentRequest()
        ;
    }

    /**
     * Returns the scheme of the current request. Generally, this will be either "http" or "https".
     *
     * @return string|null
     */
    public function getRequestScheme()
    {
        return $this
            ->requestStack()
            ->getCurrentRequest()
            ->getScheme()
        ;
    }

    /**
     * Returns the host of the current request.
     *
     * @return string|null
     */
    public function getRequestHost()
    {
        return $this
            ->requestStack()
            ->getCurrentRequest()
            ->getHost()
        ;
    }

    /**
     * Concatenates and returns the result of {@see self::getRequestScheme()} and {@see self::getRequestHost()} to provide the full
     * base URL of the current request.
     *
     * @return string|null
     */
    public function getRequestSchemeAndHost()
    {
        return $this
            ->requestStack()
            ->getCurrentRequest()
            ->getSchemeAndHttpHost()
        ;
    }

    /**
     * Return node creator service.
     *
     * @return NodeCreatorInterface
     */
    public function node()
    {
        return $this->getService('s.mantle.node_creator');
    }

    /**
     * Attempts to render a node. Tries to do so in the following order: by Node entity, by node slug, by node
     * materialized path.
     *
     * @param Node|string $search
     * @param mixed       $arguments
     *
     * @throws ControllerException
     *
     * @return string
     */
    public function getNodeRendered($search, ...$arguments)
    {
        try {
            return $this->renderNodeEntity($search, $arguments);
        } catch (\Exception $e) {
            // Ignore as we will try finding node by slug next
        }

        try {
            return $this->renderNodeBySlug($search, $arguments);
        } catch (\Exception $e) {
            // Ignore as we will try finding node by slug next
        }

        try {
            return $this->renderNodeByPath($search, $arguments);
        } catch (\Exception $e) {
            // Ignore as we throw specific exception for this situation next
        }

        throw $this->getExceptionGeneric('Could not find the requested node in %s.', __METHOD__);
    }

    /**
     * Renders a node.
     *
     * @param Node $node
     * @param mixed ...$arguments
     *
     * @return string
     */
    public function renderNodeEntity(Node $node, ...$arguments)
    {
        return $this->node()->render($node, $arguments);
    }

    /**
     * @param $slug
     * @param ...$arguments
     *
     * @return mixed
     */
    public function renderNodeBySlug($slug, ...$arguments)
    {
        return $this->node()->renderFromSlug($slug, $arguments);
    }

    /**
     * @param $materializedPath
     * @param ...$arguments
     *
     * @return mixed
     */
    public function renderNodeByPath($materializedPath, ...$arguments)
    {
        return $this
            ->node()
            ->renderFromMaterializedPath($materializedPath, $arguments)
        ;
    }

    /**
     * Renders a template view.
     *
     * @param string $view       The path to the template view
     * @param array  $parameters An array of parameters to pass to the template renderer
     *
     * @return string
     */
    public function renderView($view, array $parameters = [])
    {
        return $this
            ->templating()
            ->render($view, $parameters)
        ;
    }

    /**
     * Get the form factory service.
     *
     * @return FormFactoryInterface
     */
    public function form()
    {
        return $this->getService('form.factory');
    }

    /**
     * Get a form via it's service type definition and/or its form definition object.
     *
     * @param string|object $type    The form type definition or a key to a form type service definition.
     * @param mixed|null    $data    Data for the form.
     * @param array         $options Options to be passed to the form.
     * @param string|null   $name    An optional name for the form (when multiple forms exist on a page)
     *
     * @return Form
     */
    public function createForm($type, $data = null, array $options = [], $name = null)
    {
        return $name === null ?
            $this->form()->create($type, $data, $options) :
            $this->form()->createNamed($name, $type, $data, $options)
        ;
    }

    /**
     * Get a form via it's service type definition and/or its form definition object.
     *
     * @param string|null   $name    An optional name for the form (when multiple forms exist on a page)
     * @param string|object $type    The form type definition or a key to a form type service definition.
     * @param mixed|null    $data    Data for the form.
     * @param array         $options Options to be passed to the form.
     *
     * @return Form
     */
    public function createFormNamed($name = null, $type, $data = null, array $options = [])
    {
        return $this->createForm($type, $data, $options, $name);
    }

    /**
     * Get a form builder.
     *
     * @param mixed|null  $data    Data for the form.
     * @param array       $options Options to be passed to the form.
     * @param string|null $name    An optional name for the form (when multiple forms exist on a page)
     *
     * @return FormBuilder
     */
    public function createFormBuilder($data = null, array $options = [], $name = null)
    {
        return $name === null ?
            $this->form()->createBuilder('form', $data, $options) :
            $this->form()->createNamedBuilder($name, 'form', $data, $options)
        ;
    }

    /**
     * Get a named form builder.
     *
     * @param string|null $name    An optional name for the form (when multiple forms exist on a page)
     * @param mixed|null  $data    Data for the form.
     * @param array       $options Options to be passed to the form.
     *
     * @return FormBuilder
     */
    public function getFormBuilderNamed($name = null, $data = null, array $options = [])
    {
        return $this->createFormBuilder($data, $options, $name);
    }

    /**
     * Get the logger service.
     *
     * @return LoggerInterface
     */
    public function logger()
    {
        return $this->getService('logger');
    }
}

/* EOF */
