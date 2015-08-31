<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace {

    /**
     * @param mixed ...$comparisonSet
     *
     * @throws Exception
     *
     * @return bool
     */
    function compare_strict(...$comparisonSet)
    {
        if (empty($comparisonSet) === true || (count($comparisonSet) < 2) === true) {
            throw new \Exception('You must provide at least two items to compare.');
        }

        $first = array_shift($comparisonSet);

        foreach ($comparisonSet as $setItem) {
            if ($setItem !== $first) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $item
     *
     * @return bool
     */
    function is_array_empty($item)
    {
        if (false === is_array($item)) {
            return false;
        }

        if (false === empty($item)) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $array
     *
     * @return bool|int
     */
    function count_array($array = [])
    {
        if (false === is_array($array) && false === ($array instanceof \Countable)) {
            return false;
        }

        return (int)count($array);
    }

    /**
     * @param string $key
     * @param array  $array
     *
     * @return null|mixed
     */
    function try_for_array_value($key, array $array)
    {
        if (false === array_key_exists($key, $array)) {
            return null;
        }

        return $array[$key];
    }

    /**
     * Helper function to get first element of an array (works around the fact that PHP won't return a function/method
     * value by reference).
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_first(array $array = [])
    {
        $arrayItem = reset($array);

        return ($arrayItem === false ? null : $arrayItem);
    }

    /**
     * Helper function to get last element of an array (works around the fact that PHP won't return a function/method
     * value by reference).
     *
     * @param array $array
     *
     * @return mixed
     */
    function array_last(array $array = [])
    {
        $arrayItem = end($array);

        return ($arrayItem === false ? null : $arrayItem);
    }

    /**
     * @param string      $application
     * @param string|null $framework
     *
     * @return bool
     */
    function enable_new_relic_extension($application, $framework = null)
    {
        if (false === extension_loaded('newrelic') ||
            false === function_exists('newrelic_set_appname')
        ) {
            return false;
        }

        newrelic_set_appname($application);

        if (null !== $framework) {
            ini_set('newrelic.framework', $framework);
        }

        return true;
    }

    /**
     * @param string $string
     *
     * @return bool
     */
    function is_null_or_empty_string($string)
    {
        return (bool) ($string === null || strlen((string) $string) === 0);
    }
}

/* EOF */
