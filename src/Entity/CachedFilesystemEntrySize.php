<?php

namespace Scribe\MantleBundle\Entity;

use Scribe\Entity\AbstractEntity;
use Scribe\EntityTrait\HasAttributes;
use Scribe\EntityTrait\HasDatetime;

/**
 * Class CachedFilesystemEntrySize
 * @package Scribe\MantleBundle\Entity
 */
class CachedFilesystemEntrySize extends AbstractEntity
{
    use HasAttributes,
        HasDatetime;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var integer
     */
    private $sizeBytes;

    /**
     * @var integer
     */
    private $sizeHuman;

    /**
     * @var string
     */
    private $typeHuman;

    /**
     * Cast to string
     * @return string
     */
    public function __toString()
    {
        return $this->getIdentifier();
    }

    /**
     * @param string $identifier
     *
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = (string) $identifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return (string) $this->identifier;
    }

    /**
     * @param int $sizeBytes
     *
     * @return $this
     */
    public function setSizeBytes($sizeBytes)
    {
        $this->sizeBytes = (int) $sizeBytes;

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeBytes()
    {
        return (int) $this->sizeBytes;
    }

    /**
     * @param $sizeHuman
     *
     * @return $this
     */
    public function setSizeHuman($sizeHuman)
    {
        $this->sizeHuman = (float) $sizeHuman;

        return $this;
    }

    /**
     * @return float
     */
    public function getSizeHuman()
    {
        return (float) $this->sizeHuman;
    }

    /**
     * @param string $typeHuman
     *
     * @return $this
     */
    public function setTypeHuman($typeHuman)
    {
        $this->typeHuman = (string) $typeHuman;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeHuman()
    {
        return (string) $this->typeHuman;
    }
}

/* EOF */
