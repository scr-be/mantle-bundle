<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Model\SoftDeletable;

/**
 * Class SoftDeletableTrait.
 */
trait SoftDeletableTrait
{
    /**
     * @var \Datetime|null
     */
    protected $deletedAt;

    /**
     * Get the deleted date (or null if not deleted).
     *
     * @return \Datetime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set the date the to soft-delete the entity.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setDeletedAt(\Datetime $when = null)
    {
        $this->deletedAt = $when;

        return $this;
    }

    /**
     * Determines if the entity has already been deleted.
     *
     * @return bool
     */
    public function isDeleted()
    {
        if (null === $this->deletedAt) {
            return false;
        }

        return (bool) ($this->deletedAt <= (new \Datetime()));
    }

    /**
     * Determines if the entity will be deleted in the future.
     *
     * @param \Datetime $when
     *
     * @return bool
     */
    public function willBeDeletedAt(\Datetime $when = null)
    {
        if ($this->deletedAt === null) {
            return false;
        } elseif ($when === null) {
            return true;
        }

        return (bool) ($this->deletedAt <= $when);
    }

    /**
     * Delete the entity now.
     *
     * @return $this
     */
    public function delete()
    {
        $this->deletedAt = new \Datetime();

        return $this;
    }

    /**
     * Restore the entity now.
     *
     * @return $this
     */
    public function restore()
    {
        $this->deletedAt = null;

        return $this;
    }
}

/* EOF */
