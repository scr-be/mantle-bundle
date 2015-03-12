<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Scribe\Utility\Caller\Call;

/**
 * Class System
 *
 * @package Scribe\Utility
 */
class System
{
    /**
     * osx (darwin) os string
     */
    const OS_DARWIN = 'Darwin';

    /**
     * linux os string
     */
    const OS_LINUX = 'Linux';

    /**
     * @param int $precision
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
     * @param int $precision
     * @param int $newBase
     * @param bool $newBaseMax
     * @param null|integer $cpuCount
     * @return array
     */
    public static function getLoadAveragesAsPercent($precision = 2, $newBase = 100, $newBaseMax = true, $cpuCount = null)
    {
        if ($cpuCount === null) {
            return System::getCpuCount();
        }

        list($time, $load01, $load05, $load15, $loadAverage)
            = System::getLoadAverages($precision)
        ;

        return [
            $time,
            Math::convertToBase($load01, $cpuCount, $newBase, $newBaseMax),
            Math::convertToBase($load05, $cpuCount, $newBase, $newBaseMax),
            Math::convertToBase($load15, $cpuCount, $newBase, $newBaseMax),
            Math::convertToBase($loadAverage, $cpuCount, $newBase),
        ];
    }

    /**
     * @return mixed
     */
    public static function getSystemName()
    {
        return System::getSystemUname('s');
    }

    /**
     * @param mixed $value
     * @param string $filterValueFunction
     * @return bool
     */
    public static function isSystemName($value, $filterValueFunction = 'strtolower')
    {
        $value = Call::func($filterValueFunction, $value);

        if (System::getSystemName() == $value) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     * @param string $filterValueFunction
     * @return bool
     */
    public static function isNotSystemName($value, $filterValueFunction = 'strtolower')
    {
        $value = Call::func($filterValueFunction, $value);

        if (System::getSystemName() == $value) {
            return true;
        }

        return false;
    }

    /**
     * @param string $mode
     * @param string $filterValueFunction
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
     * @return int
     */
    public static function getCpuCount($default = 4)
    {
        switch (System::getSystemName()) {
            case 'linux':
                $exec = "grep 'model name' /proc/cpuinfo | wc -l";
                break;
            case 'darwin':
                $exec = "sysctl hw.ncpu | awk '{print $2}'";
                break;
            default:
                $exec = null;
        }

        if (null !== $exec) {
            $result = shell_exec($exec);
        } else {
            $result = $default;
        }

        return (int)$result;
    }
}

/* EOF */
