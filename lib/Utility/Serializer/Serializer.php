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

use Scribe\Utility\Caller\Call;
use Scribe\Utility\Extension;

/**
 * Class Serializer.
 */
class Serializer extends AbstractSerializer
{
    /**
     * Perform serialization.
     *
     * @param mixed  $mixed
     * @param string $method
     *
     * @return mixed
     */
    public static function sleep($mixed, $method = self::SERIALIZE_METHOD_DEFAULT)
    {
        $serializeMethod = self::determineSerializer($method);

        return Call::func($serializeMethod, $mixed);
    }

    /**
     * Perform unserialization.
     *
     * @param mixed  $mixed
     * @param string $method
     *
     * @return mixed
     */
    public static function wake($mixed, $method = self::SERIALIZE_METHOD_DEFAULT)
    {
        $unSerializeMethod = self::determineUnSerializer($method);

        return Call::func($unSerializeMethod, $mixed);
    }

    /**
     * Handle determining the correct function call for serialization.
     *
     * @param string $method
     *
     * @return string
     */
    public static function determineSerializer($method)
    {
        switch (self::sanitizeSerializerMethod($method)) {
            case self::SERIALIZE_METHOD_IGBINARY;

                return 'igbinary_serialize';

            case self::SERIALIZE_METHOD_JSON;

                return 'json_encode';

            case self::SERIALIZE_METHOD_NATIVE;
            default:
                return 'serialize';
        }
    }

    /**
     * Handle determining the correct function call for unserialization.
     *
     * @param string $method
     *
     * @return string
     */
    public static function determineUnSerializer($method)
    {
        switch (self::sanitizeSerializerMethod($method)) {
            case self::SERIALIZE_METHOD_IGBINARY;

                return 'igbinary_unserialize';

            case self::SERIALIZE_METHOD_JSON;

                return 'json_decode';

            case self::SERIALIZE_METHOD_NATIVE;
            default:
                return 'unserialize';
        }
    }

    /**
     * Determine the serialization method (as available).
     *
     * @param string $method
     *
     * @return string
     */
    public static function sanitizeSerializerMethod($method)
    {
        if ($method == self::SERIALIZE_METHOD_IGBINARY && Extension::hasIgbinary()) {
            return $method;
        } elseif ($method === self::SERIALIZE_METHOD_JSON && Extension::hasJson()) {
            return $method;
        }

        return self::SERIALIZE_METHOD_NATIVE;
    }
}

/* EOF */
