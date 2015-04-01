<?php
/*
 * This file is part of the Scribe Mantle Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Entity;

use Scribe\Tests\Helper\AbstractMantleEntityPhactoryUnitTestHelper;
use Scribe\MantleBundle\Entity\NodeRevision;
use Scribe\MantleBundle\Entity\NodeRenderEngine;

/**
 * Class NodeRevisionTest 
 */
class NodeRevisionTest extends AbstractMantleEntityPhactoryUnitTestHelper
{
    /**
     * @var string
     */
    private $repo;

    /**
     * @var string
     */
    private $nodeRevisions;

    /**
     * @var string
     */
    private $firstNodeRevision;

    public function setUp()
    {
        $this->repo = $this->container->get($this->config['nodeRevision']['service']); 
    }

    public function setupAndExercise($count = 1)
    {
        $this->makeNodeRevisions($count);
        $this->nodeRevisions = $this->nodeRevisionRows();
        $this->firstNodeRevision = $this->nodeRevisionRows()[0];
    }

    public function makeTwigRenderEngine()
    {
       $engine = new NodeRenderEngine(); 
       $engine->setSlug('twig');
       $closure = 
           function($twigService, $content, $args = array()) {
               $tpl = $twigService->createTemplate($content); 

               return $tpl->render($args);
       };
       $engine->setClosure($closure);

       return $engine;
    }

    public function testRender()
    {
        $this->setupAndExercise(1);
        $rev = $this->firstNodeRevision;
        $twigEnv = $this->container->get('twig');
        $args = array('title' => 'My Foo Title');
        $template = 
            <<<EOT
<div class="test">
    {{ title }}
</div>
EOT;
        $expected = 
            <<<EOT
<div class="test">
    My Foo Title
</div>
EOT;
        $rev->setContent($template);
        $rev->setRenderEngine($this->makeTwigRenderEngine());
        $content = $rev->render($twigEnv, $args);

        $this->assertXmlStringEqualsXmlString($expected, $content);
    }
}
