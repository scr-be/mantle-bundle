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
