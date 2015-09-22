<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Behavior\Subscriber;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Scribe\Wonka\Utility\Reflection\ClassReflectionAnalyserInterface;

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
     * Subscriber fields.
     *
     * @var array
     */
    protected $subscriberFields;

    /**
     * Subscriber trigger functions.
     *
     * @var array
     */
    protected $subscriberTriggers;

    /**
     * Construct the subscriber with a class reflection analysis class.
     *
     * @param ClassReflectionAnalyserInterface $classReflectionAnalyser
     * @param string[]                         $subscribedEventConstants
     * @param string[]                         $subscriberTriggers
     * @param string[]                         $requiredTraits
     * @param string[]                         $subscriberFields
     * @param bool                             $recursiveAnalysis
     */
    public function __construct(ClassReflectionAnalyserInterface $classReflectionAnalyser,
                                array $subscribedEventConstants = [],
                                array $subscriberTriggers = [],
                                array $requiredTraits = [],
                                array $subscriberFields = [],
                                $recursiveAnalysis = true
    ) {
        $this->classReflectionAnalyser = $classReflectionAnalyser;
        $this->recursiveAnalysis = $recursiveAnalysis;
        $this->requiredTraits = $requiredTraits;
        $this->subscribedEvents = $this->resolveEventConstantsToValues($subscribedEventConstants);
        $this->subscriberTriggers = $subscriberTriggers;
        $this->subscriberFields = $subscriberFields;
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
     * Get the subscriber entity fields.
     *
     * @return string[]
     */
    public function getSubscriberFields()
    {
        return $this->subscriberFields;
    }

    /**
     * Get the subscriber triggers.
     *
     * @param null|string $for
     *
     * @return string[]
     */
    public function getSubscriberTriggers($for = null)
    {
        if (null === $for) {
            return $this->subscriberTriggers;
        }

        $triggers = [];
        foreach ($this->subscribedEvents as $i => $event) {
            if ($for === $event) {
                $triggers[] = $this->subscriberTriggers[$i];
            }
        }

        return $triggers;
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
     * @param bool             $requireAll
     *
     * @return bool
     */
    protected function isSupported(\ReflectionClass $reflectionClass, $requireAll = true)
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

            if ($requireAll === true) {
                if (true !== $r) {
                    return false;
                }
            } else {
                if (true === $r) {
                    return true;
                }
            }
        }

        return (bool) ($requireAll ?: false);
    }

    /**
     * Returns the class metadata and reflection class of entity if possible.
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     *
     * @return array|null
     */
    protected function getHelperObjectsForLoadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        if ((null === ($classMetadata = $eventArgs->getClassMetadata())) ||
            (true !== ($reflectionClass = $classMetadata->getReflectionClass()) instanceof \ReflectionClass)) {
            return [
                null,
                null,
            ];
        }

        return [
            $classMetadata,
            $reflectionClass,
        ];
    }

    /**
     * Returns the class metadata and reflection class of entity if possible.
     *
     * @param LifecycleEventArgs $eventArgs
     *
     * @return array|null
     */
    protected function getHelperObjectsForLifecycleEvent(LifecycleEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $entity = $eventArgs->getEntity();
        $uow = $em->getUnitOfWork();
        $classMetadata = $em->getClassMetadata(get_class($entity));
        $reflectionClass = $classMetadata->getReflectionClass();

        return [
            $em,
            $entity,
            $reflectionClass,
            $uow,
            $classMetadata,
        ];
    }
}

/* EOF */
