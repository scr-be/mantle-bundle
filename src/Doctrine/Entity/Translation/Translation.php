<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Translation;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\ORM\Mapping\IdEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\HasSlug;

/**
 * Class Translation;
 */
class Translation extends IdEntity
{
    use HasSlug;

    /**
     * @var TranslationDomain
     */
    protected $domain;

    /**
     * @var TranslationMessage[]|ArrayCollection
     */
    protected $messageCollection;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getSlug();
    }

    /**
     * Define the values that should be serialized for this entity.
     *
     * @return $this
     */
    public function initializeSerializable()
    {
        $this->setSerializablePropertyCollection('id', 'slug', 'domain', 'locale', 'value');

        return $this;
    }

    /**
     * @return $this
     */
    public function initializeMessageCollection()
    {
        $this->messageCollection = new ArrayCollection;

        return $this;
    }

    /**
     * @param null|TranslationMessage[]|ArrayCollection $messageCollection
     *
     * @return $this
     */
    public function setMessageCollection($messageCollection)
    {
        if (is_array($messageCollection)) {
            $messageCollection = new ArrayCollection($messageCollection);
        }

        if ($messageCollection === null) {
            $messageCollection = new ArrayCollection;
        }

        if ($messageCollection instanceof ArrayCollection) {
            $this->messageCollection = $messageCollection;
        }

        return $this;
    }

    /**
     * @return ArrayCollection|TranslationMessage[]
     */
    public function getMessageCollection()
    {
        return $this->messageCollection;
    }

    /**
     * @return bool
     */
    public function hasMessageCollection()
    {
        return (bool) ($this->messageCollection->isEmpty() !== true);
    }

    /**
     * @return $this
     */
    public function clearMessageCollection()
    {
        return $this->initializeMessageCollection();
    }

    /**
     * @param TranslationMessage $message
     *
     * @return $this
     */
    public function addMessage(TranslationMessage $message)
    {
        if ($this->hasMessage($message) !== true) {
            $this->messageCollection->add($message);
        }

        return $this;
    }

    /**
     * @param TranslationMessage $message
     *
     * @return bool
     */
    public function hasMessage(TranslationMessage $message)
    {
        return (bool) ($this->messageCollection->contains($message));
    }

    /**
     * @return $this
     */
    public function initializeDomain()
    {
        $this->domain = null;

        return $this;
    }

    /**
     * @param TranslationDomain $domain
     *
     * @return $this
     */
    public function setDomain(TranslationDomain $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return TranslationDomain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return bool
     */
    public function hasDomain()
    {
        return (bool) ($this->domain !== null);
    }

    /**
     * @return $this
     */
    public function clearDomain()
    {
        return $this->initializeDomain();
    }
}

/* EOF */
