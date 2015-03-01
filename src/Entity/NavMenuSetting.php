<?php

namespace Scribe\MantleBundle\Entity;

/**
 * NavMenuSetting
 */
class NavMenuSetting
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $context;

    /**
     * @var string
     */
    private $k;

    /**
     * @var string
     */
    private $v;

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
     * Set context
     *
     * @param string $context
     * @return NavMenuSetting
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set k
     *
     * @param string $k
     * @return NavMenuSetting
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
     * @return NavMenuSetting
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
