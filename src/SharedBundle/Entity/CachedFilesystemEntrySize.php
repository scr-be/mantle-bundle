<?php

namespace Scribe\SharedBundle\Entity;

use Scribe\SharedBundle\Entity\Base\Entity;

/**
 * Class CachedFilesystemEntrySize
 * @package Scribe\SharedBundle\Entity
 */
class CachedFilesystemEntrySize extends Entity
{
    /**
     * @var \DateTime
     */
    private $datetime;

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
     * @var array
     */
    private $attributes;

    public function __toString()
    {
        return $this->getIdentifier();
    }

    /**
     * @param \Datetime $datetime
     *
     * @return $this
     */
    public function setDatetime(\Datetime $datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @param string|null $format
     *
     * @return \DateTime
     */
    public function getDatetime($format = null)
    {
        if ($format !== null) {
            return $this->datetime->format($format);
        }

        return $this->datetime;
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

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = (array) $attributes;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return (array) $this->attributes;
    }

    /**
     * @return bool
     */
    public function hasAttributes()
    {
        return (bool) is_array($this->attributes) && sizeof($this->attributes) > 0;
    }
}
