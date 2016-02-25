<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Translation;

use Scribe\MantleBundle\Component\DependencyInjection\Aware\EntityManagerAwareTrait;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * Class DatabaseLoader.
 */
class DatabaseLoader implements LoaderInterface
{
    use EntityManagerAwareTrait;

    /**
     * @param mixed  $resource
     * @param string $locale
     * @param string $domain
     *
     * @return MessageCatalogue
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($this->getMessages(), $domain);

        return $catalogue;
    }

    public function getMessages()
    {
        $messages = [];
    }
}
