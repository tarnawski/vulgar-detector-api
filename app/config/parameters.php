<?php

if (false !== getenv('VULGAR_DETECTOR_DATABASE')) {
    $parser = new \Icecave\Lace\DatabaseDsnParser();
    $options = $parser->parse(getenv('VULGAR_DETECTOR_DATABASE'));
    $container->setParameter('database_driver', $options['driver']);
    $container->setParameter('database_host', $options['host']);
    $container->setParameter('database_port', $options['port']);
    $container->setParameter('database_name', $options['dbname']);
    $container->setParameter('database_user', $options['user']);
    $container->setParameter('database_password', $options['password']);
}