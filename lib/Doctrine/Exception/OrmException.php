<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception;

use Exception;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class ORMException
 *
 * @package Scribe\Doctrine\Exception
 */
class ORMException extends \Doctrine\ORM\ORMException implements ORMExceptionInterface
{
    /**
     * The entity where this exception was thrown from.
     *
     * @var AbstractEntity
     */
    protected $entity;

    /**
     * The namespace and class name where this exception was thrown from.
     *
     * @var AbstractEntity
     */
    protected $namespace;

    /**
     * Constructor initializes exception arguments.
     *
     * @param AbstractEntity $entity    optional orm entity
     * @param string|null    $namespace optional full classpath, including namespace
     * @param string|null    $message   optional error message
     * @param int            $code      optional error code
     * @param Exception|null $previous  previous exception, if applicable
     */
    public function __construct(AbstractEntity $entity = null, $namespace = null, $message = null, $code = 0, Exception $previous = null)
    {
        $this->entity    = $entity;
        $this->namespace = $namespace;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Output string representation of exception with general, entity, and trace included.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) print_r($this->getExceptionDebugArray(), true);
    }

    /**
     * Returns entity object.
     *
     * @return AbstractEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Returns entity debug output array.
     *
     * @return array
     */
    public function getEntityDebugArray()
    {
        if (($this->getEntity() instanceof AbstractEntity) === false) {
            return print_r($this->getEntity(), true);
        }

        return $this->getEntity()->__debugInfo();
    }

    /**
     * Returns an array of the exception info - general info, entity debug output,
     * and back-trace included.
     *
     * @return array
     */
    private function getExceptionDebugArray()
    {
        return [
            'General' => sprintf(
                'Exception (%s extending from %s) thrown at "%s:%d" with message "%d:%s".',
                (string) get_class(),
                (string) get_class($this),
                (string) $this->getFile(),
                (int) $this->getLine(),
                (int) $this->getCode(),
                (string) $this->getMessage()
            ),
            'Entity' => $this->getEntityDebugArray(),
            'Trace'  => $this->getTrace(),
        ];
    }
}

/* EOF */
