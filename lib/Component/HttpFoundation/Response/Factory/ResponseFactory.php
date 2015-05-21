<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\HttpFoundation\Response\Factory;

use Scribe\Component\HttpFoundation\Response\Response;
use Scribe\Exception\LogicException;

/**
 * Class ResponseFactory.
 */
class ResponseFactory
{
    /**
     * @var Response
     */
    public static $response;

    /**
     * @param string      $fqcn
     * @param mixed|null  $content              The response content {@see setFinalContent()}
     * @param int|null    $status               Status for this response.
     * @param array       $headers              Headers specific to this response.
     * @param array       $headersGlobal        The global headers configured.
     * @param array       $headersTypeSpecific  The type-specific headers configured.
     * @param string|null $charsetGlobal        The global charset configured.
     * @param string|null $charsetTypeSpecific  The type-specific charset configured.
     * @param float|null  $protocolGlobal       The global charset configured.
     * @param float|null  $protocolTypeSpecific The type-specific charset configured.
     *
     * @return Response
     */
    public static function getResponse($fqcn, $content = null, $status = null, $headers = [],
                                       $headersGlobal = [], $headersTypeSpecific = [],
                                       $charsetGlobal = null, $charsetTypeSpecific = null,
                                       $protocolGlobal = null, $protocolTypeSpecific = null)
    {
        return self::getInstance($fqcn, $content, $status, $headers, $headersGlobal, $headersTypeSpecific,
                                 $charsetGlobal, $charsetTypeSpecific, $protocolGlobal, $protocolTypeSpecific);
    }

    /**
     * Instantiate a new Response object given the fully-qualified class name.
     *
     * @param string      $fqcn
     * @param mixed|null  $content              The response content {@see setFinalContent()}
     * @param int|null    $status               Status for this response.
     * @param array       $headers              Headers specific to this response.
     * @param array       $headersGlobal        The global headers configured.
     * @param array       $headersTypeSpecific  The type-specific headers configured.
     * @param string|null $charsetGlobal        The global charset configured.
     * @param string|null $charsetTypeSpecific  The type-specific charset configured.
     * @param float|null  $protocolGlobal       The global charset configured.
     * @param float|null  $protocolTypeSpecific The type-specific charset configured.
     *
     * @return null|Response
     */
    public static function getInstance($fqcn, $content = null, $status = null, $headers = [],
                                       $headersGlobal = [], $headersTypeSpecific = [],
                                       $charsetGlobal = null, $charsetTypeSpecific = null,
                                       $protocolGlobal = null, $protocolTypeSpecific = null)
    {
        try {
            self::$response = new $fqcn($content, $status, $headers, $headersGlobal, $headersTypeSpecific,
                                        $charsetGlobal, $charsetTypeSpecific, $protocolGlobal, $protocolTypeSpecific);
        } catch (\Exception $e) {
            throw new LogicException('Could not instantiate Response object "%s".', null, $e, null, (string) $fqcn);
        }

        if (self::$response instanceof Response) {
            return self::$response;
        }

        throw new LogicException('Returned object in Response instance factory is not of type Response.');
    }

    /**
     * @param array $headers
     */
    public static function setDefaultHeaders($headers)
    {
        if (true === empty($headers)) {
            return;
        }

        foreach ($headers as $h) {
            list($name, $value) = explode(':', $h, 2);

            self::$response->headers->add([
                $name => $value,
            ]);
        }
    }
}

/* EOF */
