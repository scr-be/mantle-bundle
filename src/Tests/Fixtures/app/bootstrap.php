<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;

$paths = array( realpath(__DIR__.'/../../../Resources/config/doctrine/') );
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => getenv('MANTLE_USER'),
    'password' => getenv('MANTLE_PASSWORD'),
    'dbname'   => getenv('MANTLE_DB'),
);

$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);
