<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Scribe\SharedBundle\Entity\Template\Entity,
    Scribe\SharedBundle\Entity\Template\HasName,
    Scribe\SharedBundle\Entity\Template\HasDescription;

/**
 * Class Icon
 * @package Scribe\SharedBundle\Entity
 */
class IconFamily extends Entity
{
    /**
     * import name and description entity property traits
     */
    use HasName;

    /**
     * @type string
     */
    private $prefix;

    /**
     * @type jsonArray 
     */
    private $requiredClasses;

    /**
     * @type jsonArray 
     */
    private $optionalClasses;

    /**
     * @var IconTemplate[]
     */
    private $templates;

    /**
     * @var Icon[] 
     */
    private $icons;

    /**
     * perform any entity setup
     */
    public function __construct() {}

    /**
     * Support for casting from object type to string type
     * @return string
     */
    public function __toString()
    {
        $this->getName();
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        $this->prefix;
    }
}
