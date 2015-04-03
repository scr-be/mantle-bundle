<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Subscriber;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Scribe\Utility\Reflection\ClassReflectionAnalyserInterface;

/**
 * Class AbstractSubscriber.
 */
abstract class AbstractSubscriber implements SubscriberInterface
{
    /**
     * Provides functionality to determine trait/method/property information against a reflected class.
     *
     * @var ClassReflectionAnalyserInterface
     */
    protected $classReflectionAnalyser;

    /**
     * Dictates the recursive search behavior of ClassReflectionAnalyser for traits and properties.
     *
     * @var bool
     */
    protected $recursiveAnalysis;

    /**
     * Return the array of required entity traits for this subscriber.
     *
     * @var string[]
     */
    protected $requiredTraits;

    /**
     * An array of events to report and subscribe to in the form of Event::preUpdate, etc, the
     * value of the constant is resolved at runtime.
     *
     * @var string[]
     */
    protected $subscribedEvents;

    /**
     * Subscriber fields
     *
     * @var array
     */
    protected $subscriberFields;

    /**
     * Construct the subscriber with a class reflection analysis class.
     *
     * @param ClassReflectionAnalyserInterface $classReflectionAnalyser
     * @param string[]                         $requiredTraits
     * @param string[]                         $subscribedEventConstants
     * @param bool                             $recursiveAnalysis
     */
    public function __construct(ClassReflectionAnalyserInterface $classReflectionAnalyser, array $requiredTraits = [],
                                array $subscribedEventConstants = [], array $subscriberFields = [], $recursiveAnalysis = true)
    {
        $this->classReflectionAnalyser = $classReflectionAnalyser;
        $this->recursiveAnalysis       = $recursiveAnalysis;
        $this->requiredTraits          = $requiredTraits;
        $this->subscribedEvents        = $this->resolveEventConstantsToValues($subscribedEventConstants);
        $this->subscriberFields        = $subscriberFields;
    }

    /**
     * Return the events the subscriber is subscribing to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return $this->subscribedEvents;
    }

    /**
     * Get the subscriber entity fields
     *
     * @return string[]
     */
    public function getSubscriberFields()
    {
        return $this->subscriberFields;
    }

    /**
     * Resolve the provided event constants (in the form of Event::envName) to their runtime values against
     * the namespace Doctrine\ORM\Events.
     *
     * @param array $eventConstants
     *
     * @return array
     */
    protected function resolveEventConstantsToValues(array $eventConstants)
    {
        $resolvedEvents = [];

        foreach ($eventConstants as $e) {
            if (false === defined('\\Doctrine\\ORM\\'.$e)) {
                continue;
            }

            $resolvedEvents[] = constant('\\Doctrine\\ORM\\'.$e);
        }

        return $resolvedEvents;
    }

    /**
     * Checks if this subscriber supports the passed entity through the reflection object provided.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return bool
     */
    protected function isSupported(\ReflectionClass $reflectionClass)
    {
        if (false === (count($this->requiredTraits) > 0)) {
            return true;
        }

        foreach ($this->requiredTraits as $trait) {
            $r = $this
                ->classReflectionAnalyser
                ->hasTrait(
                    $trait,
                    $reflectionClass,
                    $this->recursiveAnalysis
                )
            ;

            if (true !== $r) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the class metadata and reflection class of entity if possible.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     *
     * @return array|null
     */
    protected function getClassMetadataAndReflectionOfEntityForLoadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        if ((null === ($classMetadata = $eventArgs->getClassMetadata())) ||
            (true !== ($reflectionClass = $classMetadata->getReflectionClass()) instanceof \ReflectionClass)) {

            return [
                null,
                null
            ];
        }

        return [
            $classMetadata,
            $reflectionClass
        ];
    }
}

/* EOF */
