<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Twig_Extension;

/**
 * Class ContainerExtension
 */
class ZoomExtension extends Twig_Extension
{
    /**
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [ 'zoom' => new \Twig_Function_Method($this,'zoom') ];
    }

    /**
     * @param int $i
     * @param string $zero
     * @param string $one
     * @param null|string $more
     * @return string
     */
    public function zoom($i = 0, $zero, $one, $more = null)
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
