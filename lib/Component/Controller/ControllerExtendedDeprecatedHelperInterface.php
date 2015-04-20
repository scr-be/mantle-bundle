<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Interface ControllerExtendedDeprecatedHelperInterface.
 */
interface ControllerExtendedDeprecatedHelperInterface
{
    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::emFlush()
     */
    public function entityManagerFlush($flush = true);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::emPersist()
     */
    public function entityPersist(AbstractEntity $entity, $flush = false);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::emRemove()
     */
    public function entityRemove(AbstractEntity $entity, $flushNow = true);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::errorNotFound()
     */
    public function createNotFoundException($message = 'Requested asset not found.', \Exception $previousException = null);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::twigTpl()
     */
    public function renderView($view, array $parameters = []);

    /**
     * Return a response object from the provided string.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::responseHTML()
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function response($string = '', $status = 200, array $headers = []);

    /**
     * Return a response object from the provided string, alias for {@see response}.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::responseHTML()
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function returnResponse($string = '', $status = 200, array $headers = []);

    /**
     * Return a response object from the provided string as plain text.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::responseText()
     *
     * @param string $string  A string value to return as the response
     * @param int    $status  HTTP status code to return
     * @param array  $headers Additional headers to return
     *
     * @return Response
     */
    public function plainTextResponse($string = '', $status = 200, array $headers = []);

    /**
     * Return a response object from the generated view.
     *
     * @deprecated Beginning with release 2.0.0.
     *
     * @param string $view       The path to the template view
     * @param array  $parameters An array of paramiters to pass to the template renderer
     *
     * @return Response
     */
    public function renderResponse($view, array $parameters = []);

    /**
     * Return JSON response object instance.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::responseJSON()
     *
     * @param array  $data     JSON data to return
     * @param int    $status   HTTP status code
     * @param array  $headers  Additional HTTP headers to return with response
     * @param string $protocol HTTP protocol to use
     *
     * @return JsonResponse
     */
    public function jsonResponse(array $data = null, $status = 200, array $headers = null, $protocol = '1.1');

    /**
     * return redirect response from a provided symfony route and its (optional) arguments.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::redirectURI()
     *
     * @param string $uri     uri to redirect to
     * @param int    $status  http status code to return
     * @param array  $headers additional headers to return
     *
     * @return RedirectResponse
     */
    public function redirectResponse($uri, $status = 302, array $headers = []);

    /**
     * return redirect response from a provided symfony route and its (optional) arguments.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::responseURI()
     * @see ControllerExtendedHelperInterface::responseURL()
     * @see ControllerExtendedHelperInterface::routeURI()
     * @see ControllerExtendedHelperInterface::routeURL()
     *
     * @param string $routeName      name of the symfony route
     * @param array  $routeArguments optional arguments array for route
     * @param int    $status         http status code to return
     * @param array  $headers        additional headers to return
     *
     * @return RedirectResponse
     */
    public function routeRedirectResponse($routeName, array $routeArguments = [], $status = 302, array $headers = []);

    /**
     * Generate a url from a routename and route args.
     *
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::routeURI()
     * @see ControllerExtendedHelperInterface::routeURL()
     *
     * @param string $route         route name
     * @param array  $parameters    route parameters
     * @param string $referenceType the url reference type
     *
     * @return string
     */
    public function generateUrl($route, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::translateStr()
     */
    public function getTranslation($key);

    /**
     * @deprecated Beginning with release 2.0.0.
     * @see ControllerExtendedHelperInterface::requestScheme()
     * @see ControllerExtendedHelperInterface::requestHost()
     * @see ControllerExtendedHelperInterface::requestSchemeAndHost()
     *
     * @return string
     */
    public function getSchemeAndHost();

    /**
     * Create a named form.
     *
     * @param FormTypeInterface|null $type    form type to create
     * @param mixed                  $data    form data
     * @param array                  $options form options
     *
     * @return Form
     */
    public function createForm($type, $data = null, array $options = []);

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
    public function createNamedForm($name, $type, $data = null, array $options = []);
}

/* EOF */
