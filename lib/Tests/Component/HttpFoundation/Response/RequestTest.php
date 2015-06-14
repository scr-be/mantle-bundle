<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Component\HttpFoundation\Response;

use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;

/**
 * Class NodeCreatorTest.
 */
class RequestTest extends AbstractMantleKernelTestCase
{
    public function testRequestFactoryService()
    {
        $response = $this->container->get('s.mantle.response.type_html');

        static::assertInstanceOf('Scribe\Component\HttpFoundation\Response\ResponseInterface', $response);
        static::assertTrue($response->isOk());
        static::assertEquals('', $response->getContent());
        static::assertEquals(200, $response->getStatusCode());
        static::assertEquals(1.1, $response->getProtocolVersion());
        static::assertEquals('utf-8', $response->getCharset());
        static::assertTrue($response->hasHeader('content-type'));
    }

    public function testRequestFactoryServiceForJson()
    {
        $response = $this->container->get('s.mantle.response.type_json');
        $response->setData(['some' => 'array']);
        static::assertInstanceOf('Scribe\Component\HttpFoundation\Response\JsonResponse', $response);
        static::assertTrue($response->isOk());
        static::assertEquals('{"some":"array"}', $response->getContent());
        static::assertEquals(200, $response->getStatusCode());
        static::assertEquals(1.1, $response->getProtocolVersion());
        static::assertEquals('utf-8', $response->getCharset());
    }

    public function testRequestFactoryServiceForYaml()
    {
        $response = $this->container->get('s.mantle.response.type_yaml');
        $response->setData(['some' => 'array']);
        static::assertInstanceOf('Scribe\Component\HttpFoundation\Response\YamlResponse', $response);
        static::assertTrue($response->isOk());
        static::assertEquals(trim('some: array'), trim($response->getContent()));
        static::assertEquals(200, $response->getStatusCode());
        static::assertEquals(1.1, $response->getProtocolVersion());
        static::assertEquals('utf-8', $response->getCharset());
    }
}
