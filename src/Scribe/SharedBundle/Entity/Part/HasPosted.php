<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Part;

use DateTime;

/**
 * Class HasPosted
 */
trait HasPosted
{
    /**
     * @var Datetime
     */
    private $posted;

    /**
     * @return Datetime
     */
    public function getPosted()
    {
        return $this->posted;
    }

    /**
     * @param DateTime $datetime
     * @return $this
     */
    public function setPosted(DateTime $datetime)
    {
        $this->posted = $datetime;

        return $this;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getPostedFormatted($format='r')
    {
        return $this->getPosted()->format($format);
    }
}
