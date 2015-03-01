<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Part;

use DateTime;

/**
 * Class HasDate
 */
trait HasDate
{
    /**
     * @var Datetime
     */
    private $date;

    /**
     * @return Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $datetime
     * @return $this
     */
    public function setDate(DateTime $datetime)
    {
        $this->date = $datetime;

        return $this;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDateFormatted($format='r')
    {
        return $this->getDate()->format($format);
    }
}
