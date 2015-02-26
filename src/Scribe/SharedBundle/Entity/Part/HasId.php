<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Part;

/**
 * Class HasId
 */
trait HasId
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
