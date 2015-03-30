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
 * @param string    $string
 * @param ...string $stringVars
 *
 * @throws \LogicException
 */
function logicException($string, ...$stringVars)
{
    throw new \LogicException(
        call_user_func_array('sprintf', array_merge((array)$string, (array)$stringVars))
    );
}

/**
 * @param string $file
 *
 * @return bool|mixed
 */
function includeIfExists($file)
{
    if (file_exists($file)) {
        return include $file;
    }

    return false;
}

/**
 * @param string $path
 */
function removeDirectory($path)
{
    if (false === is_dir($path)) {
        return;
    }

    foreach ((array)glob($path.'/*') as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }

    rmdir($path);
}

/**
 * @param string $varName
 * @param mixed  $defaultValue
 *
 * @return bool
 */
function setupContainerVar($varName, $defaultValue)
{
    if (false !== ($value = getEnvVar($varName))) {
        return setServerVar(translateEnvOrServerVarName($varName), $value);
    }

    return setServerVar(translateEnvOrServerVarName($varName), $defaultValue);
}

/**
 * @param string $serverVarName
 * @param mixed  $value
 *
 * @return bool
 */
function setServerVar($serverVarName, $value)
{
    global $_SERVER;

    $_SERVER[$serverVarName] = $value;

    return true;
}

/**
 * @param string $envVarName
 *
 * @return bool
 */
function getEnvVar($envVarName)
{
    if (false !== ($value = getenv($envVarName))) {
        return $value;
    }

    return false;
}

/**
 * @param string $name
 *
 * @return string
 */
function translateEnvOrServerVarName($name)
{
    return (string) 'SYMFONY__'.$name;
}

/* EOF */
