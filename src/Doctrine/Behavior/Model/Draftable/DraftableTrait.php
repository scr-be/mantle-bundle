<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Behavior\Model\Draftable;

use Scribe\MantleBundle\Doctrine\Behavior\Model\Publishable\PublishableTrait;

/**
 * Class DraftableTrait.
 */
trait DraftableTrait
{
    /*
     * Extend publishable trait to provide draftable
     */
    use PublishableTrait;

    /**
     * Set as draft (not published).
     *
     * @return $this
     */
    public function draft()
    {
        $this->retract();

        return $this;
    }

    /**
     * Determines if it is a draft (non published).
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->isPublished();
    }
}

/* EOF */
