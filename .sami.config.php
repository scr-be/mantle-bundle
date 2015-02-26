<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Resources')
    ->exclude('Tests')
    ->exclude('Specs')
    ->exclude('Features')
    ->in($dir = realpath(__DIR__.'/../../src'))
;

$versions = GitVersionCollection::create($dir)
    ->addFromTags('v0.*')
    ->add('master', 'master branch')
;

return new Sami($iterator, array(
    'theme'                => 'enhanced',
    'versions'             => $versions,
    'title'                => 'Scribe World API',
    'build_dir'            => $dir.'/../web/api/%version%',
    'cache_dir'            => $dir.'/../web/api/_cache/%version%',
    'default_opened_level' => 2,
));
