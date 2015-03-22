<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Serializer;

/**
 * Class SerializerInterface
 *
 * @package Scribe\Utility\Serializer
 */
interface SerializerInterface
{
    /**
     * Serializer using igbinary
     * @var string
     */
    const SERIALIZE_METHOD_IGBINARY = 'igbinary';

    /**
     * Serializer using json
     * @var string
     */
    const SERIALIZE_METHOD_JSON = 'json';

    /**
     * Serializer using native PHP
     * @var string
     */
    const SERIALISE_METHOD_NATIVE = 'native';

    /**
     * Serializer default
     */
    const SERIALIZE_METHOD_DEFAULT = self::SERIALIZE_METHOD_IGBINARY;

    /**
     * @param mixed  $mixed
     * @param string $method
     * @return mixed
     */
    static public function sleep($mixed, $method = self::SERIALIZE_METHOD_DEFAULT);

    /**
     * @param mixed  $mixed
     * @param string $method
     * @return mixed
     */
    static public function wake($mixed, $method = self::SERIALIZE_METHOD_DEFAULT);
}

/* EOF */
