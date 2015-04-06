<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Class ExceptionController.
 *
 * @author Rob Frawley <rfrawley@scribenet.com>
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ExceptionController
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param Twig_Environment $twig
     * @param $debug
     */
    public function __construct(Twig_Environment $twig, $debug)
    {
        $this->twig = $twig;
        $this->debug = $debug;
    }

    /**
     * @param Request              $request
     * @param FlattenException     $exception
     * @param DebugLoggerInterface $logger
     * @param string               $format
     *
     * @return Response
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $request->setRequestFormat($format);

        $currentContent = $this->getAndCleanOutputBuffering($request->headers->get('X-Php-Ob-Level', -1));

        $code = $exception->getStatusCode();

        return new Response();
    }

    /**
     * Converts an Exception to a Response.
     *
     * @param Request              $request   The request
     * @param FlattenException     $exception A FlattenException instance
     * @param DebugLoggerInterface $logger    A DebugLoggerInterface instance
     * @param string               $format    The format to use for rendering (html, xml, ...)
     *
     * @return Response
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     */
    public function showAAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $request->setRequestFormat($format);

        $currentContent = $this->getAndCleanOutputBuffering($request->headers->get('X-Php-Ob-Level', -1));

        $code = $exception->getStatusCode();

        return new Response($this->twig->render(
            $this->findTemplate($request, $format, $code, $this->debug),
            array(
                'status_code'    => $code,
                'status_text'    => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                'exception'      => $exception,
                'logger'         => $logger,
                'currentContent' => $currentContent,
            )
        ));
    }

    /**
     * @param int $startObLevel
     *
     * @return string
     */
    protected function getAndCleanOutputBuffering($startObLevel)
    {
        // ob_get_level() never returns 0 on some Windows configurations, so if
        // the level is the same two times in a row, the loop should be stopped.
        $previousObLevel = null;
        $currentContent = '';

        while (($obLevel = ob_get_level()) > $startObLevel && $obLevel !== $previousObLevel) {
            $previousObLevel = $obLevel;
            $currentContent .= ob_get_clean();
        }

        return $currentContent;
    }

    /**
     * @param Request $request
     * @param string  $format
     * @param int     $code    An HTTP response status code
     * @param Boolean $debug
     *
     * @return TemplateReference
     */
    protected function findTemplate(Request $request, $format, $code, $debug)
    {
        $name = $debug ? 'exception' : 'error';
        if ($debug && 'html' == $format) {
            $name = 'exception_full';
        }

        // when not in debug, try to find a template for the specific HTTP status code and format
        if (!$debug) {
            $template = new TemplateReference('TwigBundle', 'Exception', $name.$code, $format, 'twig');
            if ($this->templateExists($template)) {
                return $template;
            }
        }

        // try to find a template for the given format
        $template = new TemplateReference('TwigBundle', 'Exception', $name, $format, 'twig');
        if ($this->templateExists($template)) {
            return $template;
        }

        // default to a generic HTML exception
        $request->setRequestFormat('html');

        return new TemplateReference('TwigBundle', 'Exception', $name, 'html', 'twig');
    }

    // to be removed when the minimum required version of Twig is >= 2.0

    /**
     * @param TemplateReference $template
     */
    protected function templateExists($template)
    {
        $loader = $this->twig->getLoader();
        if ($loader instanceof \Twig_ExistsLoaderInterface) {
            return $loader->exists($template);
        }

        try {
            $loader->getSource($template);

            return true;
        } catch (\Twig_Error_Loader $e) {
        }

        return false;
    }
}
