<?php

namespace Scribe\MantleBundle\Entity;

/**
 * ResponseSearchReplace
 */
class ResponseSearchReplace
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $k;

    /**
     * @var string
     */
    private $v;

    private $re;

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
     * @param boolean $re
     */
    public function setRe($re)
    {
        $this->re = (bool)$re;

        return $this;
    }

    public function getRe()
    {
        return $this->re;
    }

    /**
     * Set k
     *
     * @param string $k
     * @return ResponseSearchReplace
     */
    public function setK($k)
    {
        $this->k = $k;

        return $this;
    }

    /**
     * Get k
     *
     * @return string
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * Set v
     *
     * @param string $v
     * @return ResponseSearchReplace
     */
    public function setV($v)
    {
        $this->v = $v;

        return $this;
    }

    /**
     * Get v
     *
     * @return string
     */
    public function getV()
    {
        return $this->v;
    }
}
