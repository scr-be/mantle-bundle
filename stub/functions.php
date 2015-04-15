<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

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

    return (int) count($array);
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
        false === function_exists('newrelic_set_appname')) {
        return false;
    }

    newrelic_set_appname($application);

    if (null !== $framework) {
        ini_set('newrelic.framework', $framework);
    }

    return true;
}

/* EOF */
