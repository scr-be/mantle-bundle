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

        $this->assertInstanceOf('Scribe\Component\HttpFoundation\Response\Model\ResponseInterface', $response);
        $this->assertTrue($response->isOk());
        $this->assertEquals('', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1.1, $response->getProtocolVersion());
        $this->assertEquals('utf-8', $response->getCharset());
    }
}
