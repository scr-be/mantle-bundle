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

setupContainerVar('DATABASE_DRIVER', 'pdo_mysql');
setupContainerVar('DATABASE_HOST', '127.0.0.1');
setupContainerVar('DATABASE_PORT', '3306');
setupContainerVar('DATABASE_NAME', 'SymfonyMantleBundle');
setupContainerVar('DATABASE_USER', 'root');
setupContainerVar('DATABASE_PASSWORD', '');

return include __DIR__.'/bootstrap.kernel.php';

/* EOF */
