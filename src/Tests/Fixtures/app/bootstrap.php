<?php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;

$paths = array( realpath(__DIR__.'/../../../Resources/config/doctrine/') );
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => getenv('MANTLE_USER'),
    'password' => getenv('MANTLE_PASSWORD'),
    'dbname'   => getenv('MANTLE_DB'),
);

$cache = new \Doctrine\Common\Cache\ArrayCache();

$driver = new \Doctrine\ORM\Mapping\Driver\YamlDriver($paths);

$config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
$config->setMetadataCacheImpl( $cache );
$config->setQueryCacheImpl( $cache );
$config->setMetadataDriverImpl( $driver );

$entityManager = EntityManager::create($dbParams, $config);

function GetEntityManager() {
    global $entityManager;

    return $entityManager; 
}
