<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

$db = array(
    'driver'   => 'oci8',
    'hostname' => '212.201.65.202/fut1',
    'charset'  => 'utf8',
//    'options' => array('buffer_results' => true)
);

$service_manager = array(
    'factories' => array(
//        'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        'Zend\Cache\Storage\Filesystem' => function($sm) {
                $cache = Zend\Cache\StorageFactory::factory(array(
                            'adapter' => 'filesystem',
                            'plugins' => array(
                                'exception_handler' => array('throw_exceptions' => false),
                                'serializer'
                            )
                ));

                $cache->setOptions(array(
                    'cache_dir' => './data/cache'
                ));

                return $cache;
            },
    ),
);

return array(
    'db' => $db,
    'service_manager' => $service_manager,
);