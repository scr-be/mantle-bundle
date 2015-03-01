<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\MantleBundle\Templating\Helper\Timeline\Chronoline;
use Twig_Extension;

/**
 * Class ChronolineExtension
 */
class ChronolineExtension extends Twig_Extension
{
    use SimpleExtensionTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->init('chronoline');
    }

    /**
     * @return string
     */
    public function chronoline(Chronoline $chronoline)
    {
        return $chronoline->render();
    }
}
