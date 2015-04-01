<?php

namespace Scribe\MantleBundle\Entity;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasContext;

/**
 * NavMenuSetting.
 */
class NavMenuSetting extends AbstractEntity
{
    use HasContext;

    /**
     * @var string
     */
    private $k;

    /**
     * @var string
     */
    private $v;

    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.':'.$this->k;
    }

    /**
     * Set k.
     *
     * @param string $k
     *
     * @return NavMenuSetting
     */
    public function setK($k)
    {
        $this->k = $k;

        return $this;
    }

    /**
     * Get k.
     *
     * @return string
     */
    public function getK()
    {
        return $this->k;
    }

    /**
     * Set v.
     *
     * @param string $v
     *
     * @return NavMenuSetting
     */
    public function setV($v)
    {
        $this->v = $v;

        return $this;
    }

    /**
     * Get v.
     *
     * @return string
     */
    public function getV()
    {
        return $this->v;
    }
}

/* EOF */
