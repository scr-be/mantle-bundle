<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * LoadProjectFileTypeGroupData
 */
abstract class AbstractYamlFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $fixtureName
     */
    public function getFixtures($fixtureName)
    {
        $kernelRoot = $this
            ->container
            ->get('kernel')
            ->getRootDir()
        ;

        $baseDir     = $kernelRoot . '/config/knowledge/database_fixtures/';
        $yamlPath    = $baseDir . $this->buildYamlFileName($fixtureName);
        $yaml        = new Parser;

        try {
            $fixtures = $yaml->parse(file_get_contents($yamlPath));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }

        return $fixtures[$fixtureName];
    }

    /**
     * @param string $fixtureName
     */
    public function buildYamlFileName($fixtureName)
    {
        $array  = $this->camelCaseExplode($fixtureName);
        $string = strtolower(implode('_', $array));

        return $string.'_data.yml';
    }

    /**
     * @param string $string
     */
    private function camelCaseExplode($string, $lowercase = true) {
        $array = preg_split('/([A-Z][^A-Z]+)/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        if ($lowercase) array_map('strtolower', $array);
        return $array;
    }
}
