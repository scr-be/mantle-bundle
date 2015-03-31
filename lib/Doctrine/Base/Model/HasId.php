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
 * Class HasId.
 */
trait HasId
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @return $this
     */
    public function initializeId()
    {
        $this->id = null;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

/* EOF */
