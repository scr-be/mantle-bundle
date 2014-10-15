<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Class Security
 *
 * @package Scribe\Utility
 */
class Security
{
    /**
     * @param int $bytes
     * @param bool $base64
     * @return string
     */
    public static function generateRandom($bytes = 10000000, $base64 = false, $limit = null)
    {
        $generator = new SecureRandom();
        $return = $generator->nextBytes($bytes);

        if (true === $base64) {
            $return = base64_encode($return);
        }

        if ($limit !== null) {
            $return = preg_replace($limit, '', $return);
        }

        return $return;
    }

    /**
     * @param string $hashAlgorithm
     * @param bool $hashReturnRaw
     * @param int $bytes
     * @return string
     */
    public static function generateRandomHash($hashAlgorithm = 'sha512', $hashReturnRaw = false, $bytes = 10000000)
    {
        $random = Security::generateRandom($bytes);

        return hash(
            $hashAlgorithm,
            $random,
            $hashReturnRaw
        );
    }

    /**
     * @param $password
     * @param string $pattern
     * @return bool
     */
    public static function doesPasswordMeetRequirements($password, $pattern = '#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#')
    {
        if (preg_match($pattern, $password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomPassword($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";

        while (true) {
            $password = substr(str_shuffle($chars), 0, $length);
            if (true === self::doesPasswordMeetRequirements($password)) {
                break;
            }
        }

        return $password;
    }
}
