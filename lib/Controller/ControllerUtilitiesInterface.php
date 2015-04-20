<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Scribe\Component\HttpFoundation\Exception\AbstractHttpException;
use Scribe\MantleBundle\Templating\Generator\Node\NodeCreatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Scribe\Component\Controller\Exception\ControllerException;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Entity\Route\Route;

/**
 * Interface ControllerUtilitiesInterface.
 */
interface ControllerUtilitiesInterface
{
    /**
     * Returns the container.
     *
     * @return ContainerInterface
     */
    public function container();

    /**
     * Provides an array of services corresponding to the array of service IDs provided as parameters.
     *
     * @param string,... $keys An array of service IDs to resolve from the container.
     *
     * @return mixed[]
     */
    public function getServiceCollection(...$keys);

    /**
     * Provides a service definition based on the service ID provided.
     *
     * @param string $key A service key to resolve from the container
     *
     * @return mixed
     */
    public function getService($key);

    /**
     * Check if a service exists within the container.
     *
     * @param string $key A service key to search for within the container.
     *
     * @return mixed
     */
    public function hasService($key);

    /**
     * Provides an array of parameters corresponding to an array of parameter keys provided as method arguments.
     *
     * @param string ...$keys The parameter keys to resolve.
     *
     * @return mixed
     */
    public function getParameterCollection(...$keys);

    /**
     * Provides a parameter value based on the key provided.
     *
     * @param string $key A parameter key to resolve.
     *
     * @return mixed
     */
    public function getParameter($key);

    /**
     * Checks if a parameter exists within the container.
     *
     * @param string $key A parameter key to check for within the container.
     *
     * @return bool
     */
    public function hasParameter($key);

    /**
     * Access the entity manager quickly through this short hand method.
     *
     * @return EntityManagerInterface
     */
    public function em();

    /**
     * Flush the pending ORM change set to the database.
     *
     * @param bool $now Should this action literally place *now*?
     *
     * @return bool
     */
    public function emFlush($now = true);

    /**
     * Persist an entity to the database.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change set immediately or not.
     *
     * @return bool
     */
    public function emPersist(AbstractEntity $entity, $flush = false);

    /**
     * Remove an orm entity and optionally flush the transaction.
     *
     * @param AbstractEntity $entity An entity instance.
     * @param bool           $flush  Whether to flush ORM change set immediately or not.
     *
     * @return bool
     */
    public function emRemove(AbstractEntity $entity, $flush = false);

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
    public function getTwigTpl($templateName, ...$parameters);

    /**
     * Renders a template from the provided string.
     *
     * @param string  $templateString The template file to render.
     * @param mixed[] $parameters     An array of parameters passed to the template.
     *
     * @return string
     */
    public function getTwigStr($templateString, ...$parameters);

    /**
     * Returns an HTML response using the provided parameters to construct the Response object instance. The Response
     * object constructor parameters can be found via the Symfony API docs.
     *
     * @link http://api.symfony.com/2.7/Symfony/Component/HttpFoundation/Response.html
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseHTML(...$parameters);

    /**
     * Returns a text response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponseHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseText(...$parameters);

    /**
     * Returns a JSON response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponseHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseJSON(...$parameters);

    /**
     * Returns a YAML response using the provided parameters to construct the Response object instance. For additional
     * parameter and usage information reference {@see getResponseHTML()}.
     *
     * @param mixed[] $parameters Parameters passed to the Response constructor.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseYAML(...$parameters);

    /**
     * Provides a newly initialized Response object without any configuration applied.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponseGeneric();

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectURI($uri);

    /**
     * Returns a RedirectResponse configured based on the provided URL.
     *
     * @param string $url
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectURL($url);

    /**
     * Returns a RedirectResponse configured based on the passed Route entity provided.
     *
     * @param Route $route
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectRoute(Route $route);

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
    public function getRouteURI($key, ...$parameters);

    /**
     * Uses the Router service to create a URL based on the route key and parameters provided.
     *
     * @param string  $key
     * @param mixed[] $parameters
     *
     * @return string
     */
    public function getRouteURL($key, ...$parameters);

    /**
     * Accepts any exception extending AbstractHttpException and returns the same exception populated with a
     * collection of additional debugging attributes. The intended use is to throw the return value of this
     * function (versus simply throwing the exception itself); by wrapping the exception in this method, it
     * intelligently handles providing the exception with request-specific information.
     *
     * @param AbstractHttpException $exception
     *
     * @return AbstractHttpException
     */
    public function processException(AbstractHttpException $exception);

    /**
     * Creates and returns a generic http exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionGeneric($message = null, ...$sprintfArgs);

    /**
     * Creates and returns a not found exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionNotFound($message = null, ...$sprintfArgs);

    /**
     * Creates and returns an unauthorized exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionUnauthorized($message = null, ...$sprintfArgs);

    /**
     * Returns the session service from the container.
     *
     * @return SessionInterface
     */
    public function session();

    /**
     * Add a flash message to the session of type "info" - shown to the user on page rendering.
     *
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfo($message, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "success" - shown to the user on page rendering.
     *
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccess($message, ...$sprintfArgs);

    /**
     * Add a flash message to the session of type "error" - shown to the user on page rendering.
     *
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgError($message, ...$sprintfArgs);

    /**
     * Provides the user token service from the container.
     *
     * @return TokenInterface
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
     * @param string $key A translation key.
     *
     * @return string
     */
    public function getTranslation($key);

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
     * Determines if the current request-scrope is the master request.
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
     * Render a node from a node entity
     *
     * @param Node  $node
     * @param array $args
     *
     *
     */
}

/* EOF */
