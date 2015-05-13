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

use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class ContainerExtension.
 */
class ZoomExtension extends AbstractTwigExtension
{
    /**
     * Initialize the instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addFunction('zoom', [$this, 'handleZeroOneOrMore']);
    }

    /**
     * @param int         $i
     * @param string      $zero
     * @param string      $one
     * @param null|string $more
     *
     * @return string
     */
    public function handleZeroOneOrMore($i = 0, $zero, $one, $more = null)
    {
        switch ($i) {
            case 0:
                return $zero;
            case 1:
                return $one;
        }

        if ($more === null) {
            $more = $zero;
        }

        return $more;
    }
}
