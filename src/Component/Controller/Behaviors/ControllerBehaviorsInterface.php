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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Scribe\Component\Controller\Exception\ControllerException;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerParameterException;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Exception\RuntimeException;
use Scribe\MantleBundle\Doctrine\Entity\Route\Route;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Templating\Generator\Node\Model\NodeCreatorInterface;

/**
 * Interface ControllerBehaviorsInterface.
 */
interface ControllerBehaviorsInterface
{
    /**
     * Service id of the default entity manager.
     *
     * @var string
     */
    const EM_DEFAULT_ID = 'doctrine.orm.default_entity_manager';

    /**
     * Session message type for informational messages.
     *
     * @var string
     */
    const SESSION_MSG_INFO = 'info';

    /**
     * Session message type for success messages.
     *
     * @var string
     */
    const SESSION_MSG_SUCCESS = 'success';

    /**
     * Session message type for error messages.
     *
     * @var string
     */
    const SESSION_MSG_ERROR = 'error';

    /**
     * @param ContainerInterface $serviceContainer
     *
     * @internal
     *
     * @return $this
     */
    public function setServiceContainer(ContainerInterface $serviceContainer);

    /**
     * @return ContainerInterface
     */
    public function container();

    /**
     * Provides an array of services corresponding to the array of service IDs provided as parameters.
     *
     * @param string,... $id An array of service IDs to resolve from the container.
     *
     * @return mixed[]
     */
    public function getServiceCollection(...$ids);

    /**
     * Provides a service definition based on the service ID provided.
     *
     * @param string $id A service key to resolve from the container
     *
     * @throws InvalidContainerServiceException|\Exception
     *
     * @return mixed
     */
    public function getService($id);

    /**
     * Check if a service exists within the container.
     *
     * @param string $id A service key to search for within the container.
     *
     * @return mixed
     */
    public function hasService($id);

    /**
     * Provides an array of parameters corresponding to an array of parameter keys provided as method arguments.
     *
     * @param string,... $ids The parameter keys to resolve.
     *
     * @return mixed
     */
    public function getParameterCollection(...$ids);

    /**
     * Provides a parameter value based on the key provided.
     *
     * @param string $id A parameter key to resolve.
     *
     * @throws InvalidContainerParameterException|\Exception
     *
     * @return mixed
     */
    public function getParameter($id);

    /**
     * Checks if a parameter exists within the container.
     *
     * @param string $id A parameter key to check for within the container.
     *
     * @return bool
     */
    public function hasParameter($id);

    /**
     * Get the doctrine registry service.
     *
     * @return Registry
     */
    public function doctrine();

    /**
     * Access the entity manager quickly through this short hand method.
     *
     * @param string|null $id The id of the EM service if not the default.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function em($id = null);

    /**
     * Flush the pending ORM change-set to the DB.
     *
     * @param bool $now Should the change-set be flushed?
     *
     * @return $this
     */
    public function emFlush($now = true);

    /**
     * Begin a transaction.
     *
     * @return $this
     */
    public function emTransactionBegin();

    /**
     * Commit a transaction.
     *
     * @return $this
     */
    public function emTransactionCommit();

    /**
     * Rollback a transaction.
     *
     * @return $this
     */
    public function emTransactionRollback();

    /**
     * Persist an array collection of entities to the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionPersist(ArrayCollection $collection, $flush = false);

    /**
     * Remove an array collection of entities from the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionRemove(ArrayCollection $collection, $flush = false);

    /**
     * Refresh an array collection of entities. This removes any local changes and
     * brings the entities in-line with the state of the database.
     *
     * @param ArrayCollection $collection An collection of entities.
     * @param bool            $flush      Should the actions be flushed immediately?
     *
     * @return $this
     */
    public function entityCollectionRefresh(ArrayCollection $collection, $flush = false);

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
    public function entityCollectionAction($method, ArrayCollection $collection, $flush = false, $filter = true);

    /**
     * Filter a collection to ensure they all extend AbstractEntity.
     *
     * @internal
     *
     * @param ArrayCollection $collection A collection of entities.
     *
     * @return ArrayCollection
     */
    public function entityCollectionFilter(ArrayCollection $collection);

    /**
     * Persist an entity to the database.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change-set immediately or not.
     *
     * @return $this
     */
    public function entityPersist(AbstractEntity $entity, $flush = false);

    /**
     * Remove an orm entity and optionally flush the transaction.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change-set immediately or not.
     *
     * @return $this
     */
    public function entityRemove(AbstractEntity $entity, $flush = false);

    /**
     * Refreshes an entity, discarding local changes and bringing its state in-line with
     * that of the database.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityRefresh(AbstractEntity $entity);

    /**
     * Clears the entity from Doctrine's entity map. This ensures you receive a new object instance
     * when re-requesting the entity.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityClear(AbstractEntity $entity);

    /**
     * Detaches an entity from the manager. Any unfinished/pending changes to the entity will not
     * be persisted!
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return $this
     */
    public function entityDetach(AbstractEntity $entity);

    /**
     * Re-attaches (merges) an entity back into the manager and returns the managed version of the
     * entity. The passed version of the entity remains un-managed.
     *
     * @param AbstractEntity $entity An entity instance.
     *
     * @return AbstractEntity
     */
    public function entityAttach(AbstractEntity $entity);

    /**
     * Returns a new copy of the passed entity that is by default shallow-copied. A deep copy will
     * recursively copy the passed entities associations as well.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $deep   Determines if deep copy is performed (associated entities are copied).
     *
     * @return AbstractEntity
     */
    public function entityCopy(AbstractEntity $entity, $deep = false);

    /**
     * Access the templating engine service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    public function templating();

    /**
     * Access the Twig environment service.
     *
     * @return \Twig_Environment
     */
    public function twig();

    /**
     * Renders a template from a file, resolved based on the value of the template parameter.
     *
     * @param string  $templateName The template file to render.
     * @param mixed[] $parameters   An array of parameters passed to the template.
     *
     * @return string
     */
    public function renderTwigTpl($templateName, array $parameters = []);

    /**
     * Renders a template from the provided string.
     *
     * @param string  $templateString The template file to render.
     * @param mixed[] $parameters     An array of parameters passed to the template.
     *
     * @return string
     */
    public function renderTwigStr($templateString, array $parameters = []);

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
    public function getResponse($content, array $headers = [], $status = null, callable $config = null);

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance.
     * {@see self::getResponse()}.
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
    public function getResponseTypeHtml($content, array $headers = [], $status = null, callable $config = null);

    /**
     * Returns a text response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponse()}.
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
    public function getResponseTypeText($content, array $headers = [], $status = null, callable $config = null);

    /**
     * Returns a JSON response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponse()}.
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
    public function getResponseTypeJson($content, array $headers = [], $status = null, callable $config = null);

    /**
     * Returns a YAML response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponse()}.
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
    public function getResponseTypeYaml($content, array $headers = [], $status = null, callable $config = null);

    /**
     * @param               $name
     * @param array         $arguments
     * @param array         $headers   Any headers to send with the request.
     * @param array|int     $status    Either an integer specifying the HTTP response code or a single array element with
     *                                 its index representing the HTTP response code and the value representing the
     *                                 response status text description.
     * @param callable|null $config    A callable that should expect a single parameter of type Request, which is passed
     *                                 after the Request object has been instantiated and configured using the previous
     *                                 parameters specified. The callable must return a response object (with no
     *                                 requirement it is the same response object passed to it). If it does not return
     *                                 a Response an error will be raised.
     *
     * @return mixed
     */
    public function getResponseTypeHTMLRenderedByTwig($name, array $arguments = [], array $headers = [], $status = null, callable $config = null);

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirect($uri, $status = 302);

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByUri($uri, $status = 302);

    /**
     * Returns a RedirectResponse configured based on the provided URL.
     *
     * @param string $url
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByUrl($url, $status = 302);

    /**
     * Returns a RedirectResponse configured based on the passed Route entity provided.
     *
     * @param Route $route
     * @param int   $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByRouteEntity(Route $route, $status = 302);

    /**
     * Returns a RedirectResponse based on a route.
     *
     * @param string $routePath
     * @param array  $routeParameters
     * @param int    $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByRouterKey($routePath, array $routeParameters = [], $status = 302);

    /**
     * Provides the router service from the container.
     *
     * @return RouterInterface
     */
    public function router();

    /**
     * Uses the Router service to create a URI based on the route key and parameters provided.
     *
     * @param string  $key
     * @param mixed[] $parameters
     *
     * @return string
     */
    public function getRouteUri($key, array $parameters = []);

    /**
     * Uses the Router service to create a URL based on the route key and parameters provided.
     *
     * @param string  $key
     * @param mixed[] $parameters
     *
     * @return string
     */
    public function getRouteUrl($key, array $parameters = []);

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
    public function processException(\Exception $exception);

    /**
     * Creates and returns a generic http exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionGeneric($message = null, ...$sprintfArgs);

    /**
     * Creates and returns a not found exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionNotFound($message = null, ...$sprintfArgs);

    /**
     * Creates and returns an unauthorized exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string    $message     The exception message string.
     * @param mixed,... $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionUnauthorized($message = null, ...$sprintfArgs);

    /**
     * Returns the session service from the container.
     *
     * @return Session
     */
    public function session();

    /**
     * Add a flash message to the session of type "info" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfo($message, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "info" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfoByTrans($translationKey, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "success" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccess($message, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "success" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccessByTrans($translationKey, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "error" - shown to the user on page rendering.
     *
     * @param string    $message
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgError($message, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "error" via a translation key - shown to the user on page rendering.
     *
     * @param string    $translationKey
     * @param mixed,... $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgErrorByTrans($translationKey, ...$sprintfArgs);

    /**
     * Provides the user token storage service from the container.
     *
     * @return TokenStorage
     */
    public function tokenStorage();

    /**
     * Provides the user token service from the container.
     *
     * @return TokenInterface|null
     */
    public function token();

    /**
     * Provides the authorization service from the container.
     *
     * @return AuthorizationCheckerInterface
     */
    public function auth();

    /**
     * Provides the user entity for the current session, or returns null if no user is available (such as when a user
     * has not logged on).
     *
     * @throws RuntimeException
     *
     * @return AdvancedUserInterface|null
     */
    public function user();

    /**
     * Returns the translation service.
     *
     * @return TranslatorInterface
     */
    public function translator();

    /**
     * Resolves the string value based on a provided key.
     *
     * @param string    $key       A translation key.
     * @param mixed,... $parameter Parameters for the translation.
     *
     * @return string
     */
    public function getTranslation($key, ...$parameters);

    /**
     * Returns the request stack service.
     *
     * @return RequestStack
     */
    public function requestStack();

    /**
     * Returns the current request by querying the request stack service. Returns null if no current exists.
     *
     * @return Request|null
     */
    public function getRequestCurrent();

    /**
     * Returns the master request by querying the request stack service. Returns null if no master request exists.
     *
     * @return Request|null
     */
    public function getRequestMaster();

    /**
     * Determines if the current request-scope is the master request.
     *
     * @return bool
     */
    public function isRequestMaster();

    /**
     * Returns the parent request by querying the request stack service. Returns null if no parent request exists.
     *
     * @return Request|null
     */
    public function getRequestParent();

    /**
     * Returns the scheme of the current request. Generally, this will be either "http" or "https".
     *
     * @return string|null
     */
    public function getRequestScheme();

    /**
     * Returns the host of the current request.
     *
     * @return string|null
     */
    public function getRequestHost();

    /**
     * Concatenates and returns the result of {@see self::getRequestScheme()} and {@see self::getRequestHost()} to provide the full
     * base URL of the current request.
     *
     * @return string|null
     */
    public function getRequestSchemeAndHost();

    /**
     * Return node creator service.
     *
     * @return NodeCreatorInterface
     */
    public function node();

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
    public function getNodeRendered($search, ...$arguments);

    /**
     * Renders a node.
     *
     * @param Node      $node
     * @param mixed,... $arguments
     *
     * @return string
     */
    public function renderNodeEntity(Node $node, ...$arguments);

    /**
     * @param string    $slug
     * @param mixed,... $arguments
     *
     * @return mixed
     */
    public function renderNodeBySlug($slug, ...$arguments);

    /**
     * @param string    $materializedPath
     * @param mixed,... $arguments
     *
     * @return mixed
     */
    public function renderNodeByPath($materializedPath, ...$arguments);

    /**
     * Renders a template view.
     *
     * @param string $view       The path to the template view
     * @param array  $parameters An array of parameters to pass to the template renderer
     *
     * @return string
     */
    public function renderView($view, array $parameters = []);

    /**
     * Get the form factory service.
     *
     * @return FormFactoryInterface
     */
    public function form();

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
    public function createForm($type, $data = null, array $options = [], $name = null);

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
    public function createFormNamed($name = null, $type, $data = null, array $options = []);

    /**
     * Get a form builder.
     *
     * @param mixed|null  $data    Data for the form.
     * @param array       $options Options to be passed to the form.
     * @param string|null $name    An optional name for the form (when multiple forms exist on a page)
     *
     * @return FormBuilder
     */
    public function createFormBuilder($data = null, array $options = [], $name = null);

    /**
     * Get a named form builder.
     *
     * @param string|null $name    An optional name for the form (when multiple forms exist on a page)
     * @param mixed|null  $data    Data for the form.
     * @param array       $options Options to be passed to the form.
     *
     * @return FormBuilder
     */
    public function getFormBuilderNamed($name = null, $data = null, array $options = []);

    /**
     * Get the logger service.
     *
     * @return LoggerInterface
     */
    public function logger();
}

/* EOF */
