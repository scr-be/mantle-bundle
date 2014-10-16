<?php

/*
 * This file is part of the ScribeSymfony project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$projectRootPath = realpath(__DIR__ . DIRECTORY_SEPARATOR);

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($projectRootPath . DIRECTORY_SEPARATOR . 'src')
;

return new Sami($iterator, [
    'theme'                => 'enhanced',
    'title'                => 'Scribe Symfony Utility Library',
    'build_dir'            => $projectRootPath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'ScribeSymfontDocs',
    'cache_dir'            => '/tmp/sami/scribe-symfony',
    'default_opened_level' => 2,
]);