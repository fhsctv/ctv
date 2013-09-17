<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Generic;

//use Zend\Mvc\ModuleRouteListener;
//use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig() {

        $configPath = __DIR__ . '/config/';

        return array_merge(include $configPath. 'module.config.php'
                          ,include $configPath. 'module.config.routes.php'
                          ,include $configPath. 'module.config.navigation.php'
                          ,include $configPath. 'module.config.controllers.php'
                );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
