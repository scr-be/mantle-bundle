<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Behavior\Model\Sluggable;

/**
 * Class SluggableBehaviorStaticTrait.
 */
trait SluggableBehaviorStaticTrait
{
    use SluggableBehaviorTrait {
        SluggableBehaviorTrait::initializeSlugAutoGenerated as disabledInitializeSlugAutoGenerated;
    }

    /**
     * @return $this
     */
    public function initializeSlugAutoGenerated()
    {
        $this->slugAutoGenerated = false;

        return $this;
    }

    /**
     * @return array
     */
    public function getAutoSlugFields()
    {
        return [];
    }
}

/* EOF */
