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
    static public $response;

    /**
     * @param string      $fqcn
     * @param string|null $charset
     * @param float|null  $protocol
     * @param array|null  $headers
     *
     * @return Response
     */
    public static function getResponse($fqcn, $charset = null, $protocol = null, array $headers = null)
    {
        self::getInstance($fqcn);
        self::setDefaults($charset, $protocol, $headers);

        return self::$response;
    }

    /**
     * Instantiate a new Response object given the fully-qualified class name.
     *
     * @param string $fqcn
     *
     * @return void
     */
    public static function getInstance($fqcn)
    {
        try {
            self::$response = new $fqcn();
        } catch (\Exception $e) {
            throw new LogicException('Could not instantiate Response object "%s".', null, $e, null, (string) $fqcn);
        }

        if (self::$response instanceof Response) {
            return;
        }

        throw new LogicException('Returned object in Response instance factory is not of type Response.');
    }

    /**
     * @param string|null $charset
     * @param string|null $protocol
     * @param array       $headers
     */
    public static function setDefaults($charset, $protocol, array $headers)
    {
        self::setDefaultCharset($charset);
        self::setDefaultProtocol($protocol);
        self::setDefaultHeaders($headers);
    }

    /**
     * @param string|null $charset
     */
    public static function setDefaultCharset($charset)
    {
        self::$response->setCharset(
            empty($charset) === false ? $charset : self::$response->getDefaultCharset()
        );
    }

    /**
     * @param float|null $protocol
     */
    public static function setDefaultProtocol($protocol)
    {
        self::$response->setProtocolVersion(
            empty($protocol) === false ? $protocol : self::$response->getDefaultProtocol()
        );
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
                $name => $value
            ]);
        }
    }
}

/* EOF */
