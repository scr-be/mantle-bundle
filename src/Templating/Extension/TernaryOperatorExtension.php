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

use Scribe\WonkaBundle\Component\Templating\AbstractTwigExtension;

/**
 * Class TernaryOperatorExtension.
 */
class TernaryOperatorExtension extends AbstractTwigExtension
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->enableOptionHtmlSafe()
            ->attachExtensionFuncs();
    }

    /**
     * @return $this
     */
    protected function attachExtensionFuncs()
    {
        $this->addFunction('tern_op', [$this, 'getTernaryResult']);

        return $this;
    }

    /**
     * @param bool       $decider
     * @param mixed      $trueResult
     * @param null|mixed $falseResult
     *
     * @return null|mixed
     */
    public function getTernaryResult($decider, $trueResult, $falseResult = null)
    {
        if ($decider) {
            return $trueResult;
        }

        return $falseResult ?: null;
    }
}

/* EOF */
