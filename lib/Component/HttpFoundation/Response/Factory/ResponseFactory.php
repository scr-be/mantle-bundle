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
use Scribe\Component\HttpFoundation\Response\ResponseInterface;
use Scribe\Exception\LogicException;

/**
 * Class ResponseFactory.
 */
class ResponseFactory
{
    /**
     * @param string      $fqcn                 The fully qualified path to the class.
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
    public static function create($fqcn, $content = null, $status = null, array $headers = [],
                                  array $headersGlobal = [], array $headersTypeSpecific = [],
                                  $charsetGlobal = null, $charsetTypeSpecific = null,
                                  $protocolGlobal = null, $protocolTypeSpecific = null)
    {
        $response = null;

        try {
            $response = new $fqcn($content, $status, $headers, $headersGlobal, $headersTypeSpecific,
                                      $charsetGlobal, $charsetTypeSpecific, $protocolGlobal, $protocolTypeSpecific);
        } catch (\Exception $e) {
            throw new LogicException('Could not instantiate Response object "%s".', null, $e, null, (string) $fqcn);
        }

        if (false === ($response instanceof ResponseInterface)) {
            throw new LogicException('Returned object in Response instance factory is not of type Response.');
        }

        return $response;
    }
}

/* EOF */
