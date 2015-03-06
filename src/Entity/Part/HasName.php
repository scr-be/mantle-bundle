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

/**
 * Class HasName
 */
trait HasName
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @param array $articles
     * @return string
     */
    public function getIndexName($articles = ['The', 'An', 'A'])
    {
        $name = $this->getName();

        foreach ($articles as $a) {
            if (substr($name, 0, strlen($a)+1) == $a.' ') {
                $name = substr($name, strlen($a)+1) . ', ' . $a;
                break;
            }
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getIndexLetter()
    {
        return strtoupper(substr($this->getIndexName(), 0, 1));
    }
}

/* EOF */
