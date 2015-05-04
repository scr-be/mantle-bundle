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
use Scribe\Component\Controller\Exception\ControllerException;
use Scribe\Component\HttpFoundation\Exception\HttpException;
use Scribe\Component\HttpFoundation\Exception\NotFoundHttpException;
use Scribe\Component\HttpFoundation\Exception\UnauthorizedHttpException;
use Scribe\Doctrine\Exception\TransactionORMException;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Doctrine\Entity\Route\Route;
use Scribe\MantleBundle\Templating\Generator\Node\Model\NodeCreatorInterface;
use Scribe\Utility\Caller\Call;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerParameterException;
use Scribe\Component\DependencyInjection\Exception\InvalidContainerServiceException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
    public function getResponseTypeText($content, array $headers = [], $status = null, callable $config = null)
    {
        $headers['Content-Type'] = 'text/plain';

        return $this->getResponse($content, $headers, $status, $config);
    }

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
    public function getResponseTypeJSON($content, array $headers = [], $status = null, callable $config = null)
    {
        return $this->getResponse($content, $headers, $status, $config);
    }

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
    public function getResponseTypeYAML($content, array $headers = [], $status = null, callable $config = null)
    {
        return $this->getResponse($content, $headers, $status, $config);
    }

    /**
     * @param               $name
     * @param array         $arguments
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
     * @return mixed
     */
    public function getResponseTypeHTMLRenderedByTwig($name, array $arguments = [], array $headers = [], $status = null, callable $config = null)
    {
        $content = $this->twig()->render($name, $arguments);

        return $this->getResponse($content, $headers, $status, $config);
    }

    /**
     * Returns a RedirectResponse configured based on the provided URI.
     *
     * @param string $uri
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByURI($uri)
    {
        return new RedirectResponse($uri);
    }

    /**
     * Returns a RedirectResponse configured based on the provided URL.
     *
     * @param string $url
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByURL($url)
    {
        return new RedirectResponse($url);
    }

    /**
     * Returns a RedirectResponse configured based on the passed Route entity provided.
     *
     * @param Route $route
     *
     * @throws ControllerException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponseRedirectByRoute(Route $route)
    {
        throw new ControllerException('Not yet implemented...'.__METHOD__);
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
    public function getRouteURI($key, ...$parameters)
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
    public function getRouteURL($key, ...$parameters)
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
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
     *
     * @return ControllerException
     */
    public function getExceptionGeneric($message = null, ...$sprintfArgs)
    {
        return $this->processException(new HttpException($message, null, null, null, ...$sprintfArgs));
    }

    /**
     * Creates and returns a not found exception. This method handles passing the exception through {@see self::processException()}
     * so the returned exception is populated with additional request-specific info and can simply be thrown.
     *
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
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
     * @param string  $message     The exception message string.
     * @param mixed[] $sprintfArgs Optional additional parameters that are passed to sprintf against the passed message.
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
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgInfo($message, ...$sprintfArgs)
    {
        $this
            ->session()
            ->getFlashBag()
            ->add('info', sprintf($message, $sprintfArgs))
        ;
    }

    /**
     * Add a flash message to the session of type "success" - shown to the user on page rendering.
     *
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgSuccess($message, ...$sprintfArgs)
    {
        $this
            ->session()
            ->getFlashBag()
            ->add('success', sprintf($message, $sprintfArgs))
        ;
    }

    /**
     * Add a flash message to the session of type "error" - shown to the user on page rendering.
     *
     * @param string  $message
     * @param mixed[] $sprintfArgs
     *
     * @return $this
     */
    public function addSessionMsgError($message, ...$sprintfArgs)
    {
        $this
            ->session()
            ->getFlashBag()
            ->add('error', sprintf($message, $sprintfArgs))
        ;
    }

    /**
     * Provides the user token service from the container.
     *
     * @return TokenInterface|null
     */
    public function token()
    {
        return $this->getService('security.token_storage')->getToken();
    }

    /**
     * Provides the authorization service from the container.
     *
     * @return AuthorizationCheckerInterface
     */
    public function auth()
    {
        $this->getService('security.authorization_checker');
    }

    /**
     * Provides the user entity for the current session, or returns null if no user is available (such as when a user
     * has not logged on).
     *
     * @return AdvancedUserInterface|null
     */
    public function user()
    {
        $token = $this->token();

        if ($token === null) {
            return null;
        }

        return $token->getUser();
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
     * @param string $key          A translation key.
     * @param mixed  ...$parameter Parameters for the translation.
     *
     * @return string
     */
    public function getTranslation($key, ...$parameters)
    {
        return $this->translator()->trans($key, $parameters);
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
        return $this->requestStack()->getCurrentRequest();
    }

    /**
     * Returns the master request by querying the request stack service. Returns null if no master request exists.
     *
     * @return Request|null
     */
    public function getRequestMaster()
    {
        return $this->requestStack()->getMasterRequest();
    }

    /**
     * Determines if the current request-scrope is the master request.
     *
     * @return bool
     */
    public function isRequestMaster()
    {
        if ($this->requestStack()->getParentRequest()) {
            return false;
        }

        return true;
    }

    /**
     * Returns the parent request by querying the request stack service. Returns null if no parent request exists.
     *
     * @return Request|null
     */
    public function getRequestParent()
    {
        return $this->requestStack()->getParentRequest();
    }

    /**
     * Returns the scheme of the current request. Generally, this will be either "http" or "https".
     *
     * @return string|null
     */
    public function getRequestScheme()
    {
        return $this->requestStack()->getMasterRequest()->getScheme();
    }

    /**
     * Returns the host of the current request.
     *
     * @return string|null
     */
    public function getRequestHost()
    {
        return $this->requestStack()->getMasterRequest()->getHost();
    }

    /**
     * Concatenates and returns the result of {@see self::getRequestScheme()} and {@see self::getRequestHost()} to provide the full
     * base URL of the current request.
     *
     * @return string|null
     */
    public function getRequestSchemeAndHost()
    {
        return $this->requestStack()->getMasterRequest()->getSchemeAndHttpHost();
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
        $return = null;

        try {
            $return = $this->renderNodeEntity($search, $arguments);
        } catch (\Exception $e) {}

        if ($return !== null) {
            return $return;
        }

        try {
            $return = $this->renderNodeBySlug($search, $arguments);
        } catch (\Exception $e) {}

        if ($return !== null) {
            return $return;
        }

        try {
            $return = $this->renderNodeByPath($search, $arguments);
        } catch (\Exception $e) {}

        if ($return !== null) {
            return $return;
        }

        throw $this->getExceptionGeneric('Could not find the requested node in %s.', __METHOD__);
    }

    /**
     * Renders a node
     *
     * @param Node  $node
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
        return $this->node()->renderFromMaterializedPath($materializedPath, $arguments);
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
}

/* EOF */
