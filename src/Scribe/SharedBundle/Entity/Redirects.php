<?php

namespace Scribe\SharedBundle\Entity;

/**
 * Redirects
 */
class Redirects
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $destination;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pattern
     *
     * @param string $pattern
     * @return Redirects
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Get pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Set destination
     *
     * @param string $destination
     * @return Redirects
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
