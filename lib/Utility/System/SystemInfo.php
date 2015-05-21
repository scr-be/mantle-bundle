<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\System;

use Scribe\Utility\Caller\Call;
use Scribe\Utility\Math;

/**
 * Class SystemInfo.
 */
class SystemInfo
{
    /**
     * osx (darwin) os string.
     */
    const OS_DARWIN = 'Darwin';

    /**
     * linux os string.
     */
    const OS_LINUX = 'Linux';

    /**
     * @param int $precision
     *
     * @return array
     */
    public static function getLoadAverages($precision = 2)
    {
        $loadAverages = sys_getloadavg();

        return [
            time(),
            round($loadAverages[0], $precision),
            round($loadAverages[1], $precision),
            round($loadAverages[2], $precision),
            round(array_sum($loadAverages) / count($loadAverages), $precision),
        ];
    }

    /**
     * @param int      $precision
     * @param int      $newBase
     * @param bool     $newBaseMax
     * @param null|int $cpuCount
     *
     * @return array
     */
    public static function getLoadAveragesAsPercent($precision = 2, $newBase = 100, $newBaseMax = true, $cpuCount = null)
    {
        if ($cpuCount === null) {
            return self::getCpuCount();
        }

        list($time, $load01, $load05, $load15, $loadAverage)
            = self::getLoadAverages($precision)
        ;

        return [
            $time,
            Math::toBase($load01, $cpuCount, $newBase, $newBaseMax),
            Math::toBase($load05, $cpuCount, $newBase, $newBaseMax),
            Math::toBase($load15, $cpuCount, $newBase, $newBaseMax),
            Math::toBase($loadAverage, $cpuCount, $newBase),
        ];
    }

    /**
     * @return mixed
     */
    public static function getSystemName()
    {
        return self::getSystemUname('s');
    }

    /**
     * @param mixed  $value
     * @param string $filterValueFunction
     *
     * @return bool
     */
    public static function isSystemName($value, $filterValueFunction = 'strtolower')
    {
        $value = Call::func($filterValueFunction, $value);

        return (bool) (self::getSystemName() === $value ?: false);
    }

    /**
     * @param mixed  $value
     * @param string $filterValueFunction
     *
     * @return bool
     */
    public static function isNotSystemName($value, $filterValueFunction = 'strtolower')
    {
        return (bool) (self::isSystemName($value, $filterValueFunction) ? false : true);
    }

    /**
     * @param string $mode
     * @param string $filterValueFunction
     *
     * @return mixed
     */
    public static function getSystemUname($mode = 'a', $filterValueFunction = 'strtolower')
    {
        $result = php_uname($mode);
        $result = Call::func($filterValueFunction, $result);

        return $result;
    }

    /**
     * @param int $default
     *
     * @return int
     */
    public static function getCpuCount($default = 4)
    {
        switch (self::getSystemName()) {
            case 'linux':
                $exec = 'grep \'model name\' /proc/cpuinfo | wc -l';
                break;
            case 'darwin':
                $exec = 'sysctl hw.ncpu | awk \'{print $2}\'';
                break;
            default:
                $exec = null;
        }

        if (null !== $exec) {
            $result = shell_exec($exec);
        } else {
            $result = $default;
        }

        return (int) $result;
    }
}

/* EOF */
