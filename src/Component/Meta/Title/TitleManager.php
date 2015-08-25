<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Meta\Title;

/**
 * Class TitleManager
 */
class TitleManager
{
    /**
     * @var TitleProvider
     */
    protected $provider;

    /**
     * @var array
     */
    protected $substitutions;

    /**
     * @param TitleProvider $provider
     * @param array|null    $substitutions
     */
    public function __construct(TitleProvider $provider, array $substitutions = null)
    {
        $this->provider = $provider;
        $this->substitutions = ($substitutions === null ? [] : $substitutions);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $title = $this->provider->determineMetaTitle();

        return $this->performTitleSubstitutions($title);
    }

    /**
     * @param  string $title
     * @return string
     */
    protected function performTitleSubstitutions($title)
    {
        foreach ($this->substitutions as $search => $replace) {
            $title = preg_replace('#\b'.preg_quote($search, '#').'\b#i', $replace, $title);
        }

        return (string) $title;
    }
}
