<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

require_once __DIR__.'/bootstrap.functions.php';

removeDirectory(__DIR__.'/Fixtures/app/cache/');

if (false === ($loader = includeIfExists(__DIR__.'/../../vendor/autoload.php'))) {
    logicException(
        'You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL
    );
}

if (false === includeIfExists(__DIR__.'/Helper/app/AppKernel.php')) {
    logicException(
        'Your testing AppKernel.php could not be found! This must be implemented prior '.PHP_EOL.
        'to the tests running properly.'
    );
}

return $loader;

/* EOF */
