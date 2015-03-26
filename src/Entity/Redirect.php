<?php

namespace Scribe\MantleBundle\Entity;

use Scribe\Entity\AbstractEntity;

/**
 * Redirect.
 */
class Redirect extends AbstractEntity
{
    /**
     * @var bool
     */
    private $regex;

    /**
     * @var string
     */
    private $pathFrom;

    /**
     * @var string
     */
    private $pathTo;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->pathFrom.' -> '.$this->pathTo;
    }

    /**
     * @param bool $regex
     *
     * @return $this
     */
    public function setRegex($regex)
    {
        $this->regex = (bool) $regex;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * Set pathFrom.
     *
     * @param string $pathFrom
     *
     * @return Redirect
     */
    public function setPathFrom($pathFrom)
    {
        $this->pathFrom = $pathFrom;

        return $this;
    }

    /**
     * Get pathFrom.
     *
     * @return string
     */
    public function getPathFrom()
    {
        return $this->pathFrom;
    }

    /**
     * Set pathTo.
     *
     * @param string $pathTo
     *
     * @return Redirect
     */
    public function setPathTo($pathTo)
    {
        $this->pathTo = $pathTo;

        return $this;
    }

    /**
     * Get pathTo.
     *
     * @return string
     */
    public function getPathTo()
    {
        return $this->pathTo;
    }
}

/* EOF */
