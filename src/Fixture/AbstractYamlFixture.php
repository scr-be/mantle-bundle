<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Fixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Scribe\Exception\RuntimeException;
use Scribe\Utility\ClassName;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * AbstractYamlFixture.
 */
abstract class AbstractYamlFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Operational mode: truncate table
     *
     * @var int
     */
    const MODE_TRUNCATE = -1;

    /**
     * Operational mode: merge entries into table
     *
     * @var int
     */
    const MODE_MERGE = 0;

    /**
     * Operational mode: append to table
     *
     * @var int
     */
    const MODE_APPEND = 1;

    /**
     * Default operational mode: truncate
     *
     * @var int
     */
    const MODE_DEFAULT = self::MODE_TRUNCATE;

    /**
     * @var array
     */
    protected $fixture = [];

    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $orm = [];

    /**
     * @var int
     */
    protected $priority = 0;

    /**
     * @var array|null
     */
    protected $dependencies = [];

    /**
     * @var bool
     */
    protected $cannibal = false;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $mode = self::MODE_DEFAULT;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->init();
    }

    /**
     * Init fixture.
     */
    public function init()
    {
        $this
            ->setOrmFixtureName($this->getFixtureNameFromClassName())
            ->loadOrmFixtureData()
        ;
    }

    protected function getFixtureNameFromClassName()
    {
        return preg_replace(
            '#^Load#',
            '',
            preg_replace(
                '#Data$#',
                '',
                ClassName::getClassNameString(get_class($this))
            )
        );
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    protected function setOrmFixtureName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Forces flush on each iteration.
     *
     * @param bool $cannibal
     */
    protected function setOrmFixtureAsCannibal($cannibal = true)
    {
        $this->cannibal = (bool) $cannibal;
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return $this->data;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    protected function setOrmFixturePriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param object $entity
     * @param array  $f
     *
     * @return object
     */
    protected function setNewFixtureDataForEntity($entity, $f)
    {
        foreach ($f as $name => $value) {
            $setter = 'set'.ucfirst($name);
            $data   = $this->getFixtureDataValue($name, $f);
            try {
                $entity->$setter($data);
            } catch (ContextErrorException $e) {
                $dataCollection = new ArrayCollection($data);
                $entity->$setter($dataCollection);
            }
        }

        return $entity;
    }

    /**
     * @param string $i
     * @param array  $f
     *
     * @return array
     */
    protected function getFixtureDataValue($i, array $f = null)
    {
        if (!is_array($f) || !array_key_exists($i, $f)) {
            throw new RuntimeException(sprintf('Could not find fixture data value %s in fixtures array for fixture %s.', $i, $this->name));
        }

        return (is_array($f[$i]) ? $this->getFixtureValueAsArrayWithRefs($f[$i]) : $this->getFixtureValueWithRefs($f[$i]));
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function getFixtureValueAsArrayWithRefs(array $values = [])
    {
        foreach ($values as &$value) {
            $value = $this->getFixtureValueWithRefs($value);
        }

        return $values;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function getFixtureValueWithRefs($value)
    {
        $matches = null;
        if (0 !== preg_match('#^@([A-Za-z]*)\?([^=]*)=([^&]*)$#', $value, $matches)) {
            return $this->getFixtureValueBySearchRef($value, $matches);
        }

        $matches = null;
        if (0 !== preg_match('#^\+([a-zA-Z]*:[0-9]+)$#', $value, $matches)) {
            return $this->getFixtureValueByInternalRef($value, $matches);
        }

        return $value;
    }

    protected function getFixtureValueByInternalRef($value, $matches)
    {
        if (count($matches) !== 2) {
            return $value;
        }

        return $this->getReference($matches[1]);
    }

    protected function getFixtureValueBySearchRef($value, $matches)
    {
        if (count($matches) !== 4) {
            return $value;
        }

        $depName = $matches[1];
        $depCol = $matches[2];
        $depSch = $matches[3];

        if (!array_key_exists($depName, $this->dependencies)) {
            throw new RuntimeException(sprintf('You must specify dependency repos/entities in your YAML file for %s.', $depName));
        }

        $dep = $this->dependencies[$depName];

        if (!array_key_exists('repository', $dep)) {
            throw new RuntimeException(sprintf('You must specify dependency repo service in your YAML file for %s.', $dep['repository']));
        } else {
            $depRepo = $this->container->get($dep['repository']);
        }

        $findMethod = 'findOneBy'.ucwords($depCol);
        $result = $depRepo->$findMethod($depSch);

        return $result;
    }

    /**
     * @return object
     */
    protected function getNewFixtureEntity()
    {
        $entityName = null;
        $entity     = null;

        if (array_key_exists('entity', $this->orm)) {
            $entityName = $this->container->getParameter($this->orm['entity']);
        } else {
            $entityName = $this->name;
        }

        $entity = new $entityName();

        return $entity;
    }

    /**
     * @return $this
     *
     * @throws RuntimeException
     */
    public function loadOrmFixtureData()
    {
        $name = $this->name;

        if (null === $name) {
            throw new RuntimeException("You must provide a fixture name.");
        }

        $kernelRoot = $this
            ->container
            ->get('kernel')
            ->getRootDir()
        ;

        $baseDir     = $kernelRoot.'/config/knowledge/shared/fixtures/';
        $yamlPath    = $baseDir.$this->buildYamlFileName($name);
        $yaml        = new Parser();

        try {
            $fixture = $yaml->parse(@file_get_contents($yamlPath));
        } catch (ParseException $e) {
            throw new RuntimeException(sprintf("Unable to parse the YAML string: %s", $e->getMessage()), 0, $e);
        }

        if (!isset($fixture[$name])) {
            throw new RuntimeException(sprintf("Unable to parse the YAML root %s in file %s.", $name, $yamlPath));
        } else {
            $fixtureRoot = $fixture[$name];
        }
        var_dump($fixtureRoot);
        if (!isset($fixtureRoot['orm'])) {
            throw new RuntimeException(sprintf("Unable to find required fixture section %s in file %s.", 'orm', $yamlPath));
        } elseif (null !== $fixtureRoot['data'] && !isset($fixtureRoot['data'])) {
            throw new RuntimeException(sprintf("Unable to find required fixture section %s in file %s.", 'data', $yamlPath));
        } elseif (!array_key_exists('dependencies', $fixtureRoot)) {
            throw new RuntimeException(sprintf("Unable to find required fixture section %s in file %s.", 'dependencies', $yamlPath));
        }

        $this->fixture      = $fixtureRoot;
        $this->orm          = $fixtureRoot['orm'];
        $this->data         = $fixtureRoot['data'];
        $this->priority     = (array_key_exists('priority', $this->orm) ? $this->orm['priority'] : 0);
        $this->cannibal     = (bool) (array_key_exists('cannibal', $this->orm) ? $this->orm['cannibal'] : false);
        $this->mode         = (int) $this->determineMode();
        $this->dependencies = $fixtureRoot['dependencies'];

        return $this;
    }

    protected function determineMode()
    {
        if (false === array_key_exists('mode', $this->orm) ||
            false === ($mode = $this->orm['mode'])) {
            return self::MODE_DEFAULT;
        }

        $modeRequest = 'self::MODE_'.strtoupper($mode);

        if (true !== defined($modeRequest)) {
            return self::MODE_DEFAULT;
        }

        return constant($modeRequest);
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        if (true !== is_array($this->data)) {
            return;
        }

        foreach ($this->data as $i => $f) {
            $entity = $this->getNewFixtureEntity();
            $entity = $this->setNewFixtureDataForEntity($entity, $f);

            $manager->persist($entity);

            $this->addReference($this->name.':'.$i, $entity);

            if ($this->cannibal === true) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * @param string $fixtureName
     *
     * @return string
     */
    public function buildYamlFileName($fixtureName)
    {
        return $fixtureName.'Data.yml';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return (int) ($this->priority);
    }
}

/* EOF */
