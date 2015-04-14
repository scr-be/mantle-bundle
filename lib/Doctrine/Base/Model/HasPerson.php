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
 * Class HasPerson.
 */
trait HasPerson
{
    use HasPersonHonorific,
        HasPersonFirstName,
        HasPersonMiddleName,
        HasPersonSurname,
        HasPersonSuffix;

    /**
     * Compiles full name string
     *
     * @return string
     */
    public function getFullName()
    {
        $fullName = (string) (
            $this->getHonorific().' '.
            $this->getFirstName().' '.
            $this->getMiddleName().' '.
            $this->getSurname().' '.
            $this->getSuffix()
        );

        return preg_replace('#\s+#', ' ', trim($fullName));
    }

    /**
     * Compiles short name string
     *
     * @return string
     */
    public function getShortName()
    {
        $shortName = (string) (
            $this->getFirstName().' '.
            $this->getSurname()
        );

        return preg_replace('#\s+#', ' ', trim($shortName));
    }
}

/* EOF */
