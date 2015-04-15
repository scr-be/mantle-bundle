<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

/**
 * Class HasImportance.
 */
trait HasImportance
{
    /**
     * The importance property.
     *
     * @var int
     */
    protected $importance;

    /**
     * Set importance to announcement level by default.
     */
    public function initializeImportance()
    {
        $this->importance = null;
    }

    /**
     * @return array
     */
    public function getImportanceLevels()
    {
        return [
           -10 => 'DEPRECATION',
            0  => 'ANNOUNCEMENT',
            10 => 'NOTICE',
            20 => 'WARNING',
            30 => 'IMPORTANT',
            40 => 'CRITICAL'
        ];
    }

    /**
     * @param int $integer
     *
     * @return string|null
     */
    public function getImportanceLevelByInt($integer)
    {
        if (array_key_exists((int) $integer, $this->getImportanceLevels())) {
            return $this->getImportanceLevels()[(int) $integer];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return int|null
     */
    public function getImportanceLevelByName($name)
    {
        if (false !== ($key = array_search((string) $name, $this->getImportanceLevels()))) {
            return (int) $key;
        }

        return null;
    }

    /**
     * @param int $importance
     *
     * @return $this
     */
    public function setImportance($importance)
    {
        $this->importance = (int) $importance;

        return $this;
    }

    /**
     * @return int
     */
    public function getImportance()
    {
        return (int) $this->importance;
    }

    /**
     * @return bool
     */
    public function hasImportance()
    {
        return (bool) ($this->importance !== null ?: false);
    }

    /**
     * @return $this
     */
    public function clearImportance()
    {
        $this->initializeImportance();

        return $this;
    }
}

/* EOF */
