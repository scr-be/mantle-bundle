<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Observer;

use SplObserver;
use SplSubject;

/**
 * Class Observer
 *
 * @package Scribe\Utility\Observer
 */
abstract class Observer implements SplObserver
{
    /**
     * Called when subject observer update occures
     *
     * @param  SplSubject $subject an instance of a subject
     * @return $this
     */
    abstract public function update(SplSubject $subject);
}
