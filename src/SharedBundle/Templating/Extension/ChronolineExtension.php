<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\SharedBundle\Templating\Helper\Timeline\Chronoline;
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
