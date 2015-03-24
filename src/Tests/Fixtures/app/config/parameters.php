<?php

$container->setParameter('mantle.user', getenv('MANTLE_USER'));
$container->setParameter('mantle.db_name', getenv('MANTLE_DB'));
$container->setParameter('mantle.host', getenv('MANTLE_HOST'));
$container->setParameter('mantle.password', getenv('MANTLE_PASSWORD'));
