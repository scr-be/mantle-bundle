<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\DependencyInjection\Aware;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TranslatorAwareTrait.
 */
trait TranslatorAwareTrait
{
    /**
     * @var TranslatorInterface|null
     */
    protected $translator = null;

    /**
     * Setter for translator.
     *
     * @param TranslatorInterface|null $translator translator instance
     *
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * Getter for translator.
     *
     * @return TranslatorInterface|null
     */
    public function getTranslator()
    {
        return $this->translator;
    }
}

/* EOF */
