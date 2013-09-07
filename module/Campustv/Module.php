<?php

namespace Campustv;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;

use Campustv\Model\Entity    as Entity;
use Campustv\Model\Table     as Table;
use Campustv\Service\Factory as ServiceFactory;

use Campustv\Service\Service\Url          as UrlService;


class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface {

    const MODEL_CACHING = false;

    public function getConfig() {

        $configPath = __DIR__ . '/config/';

        return array_merge(include $configPath. 'module.config.php'
                          ,include $configPath. 'module.config.routes.php'
                          ,include $configPath. 'module.config.navigation.php'
                          ,include $configPath. 'module.config.controllers.php'
                );
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );

//        return array(
//           'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//           ),
//        );

    }

    public function getServiceConfig() {

        return array(
            'factories' => array_merge(
                 $this->getGatewayFactories()
                ,$this->getTableFactories()
                ,$this->getServiceFactories()
                ,array('Campustv\Form\Factory\Infoscript' => '\Campustv\Form\Factory\Infoscript')
            ),
            'invokables' => array(
                'Campustv\InputFilter\Infoscript' => '\Campustv\Form\InputFilter\Infoscript',
                'hydrator' => '\Zend\Stdlib\Hydrator\ClassMethods'
             ),
            'shared' => array(
                'Campustv\Form\Factory\Infoscript' => false
            ),
        );
    }

    /*
     * Dependency Injection
     * http://pastebin.com/YJtaDx1E
     */
//    public function getControllerConfig(){
//        return array();
//    }


    private function getGatewayFactories(){
        $urlTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Url());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Url());
            return new TableGateway('url', $dbAdapter, null, $resultSetPrototype);
        };
        $kundeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Kunde());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Kunde());
            return new TableGateway('tbl_partner', $dbAdapter, null, $resultSetPrototype);
        };
        $positionTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Position());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Position());
            return new TableGateway('position', $dbAdapter, null, $resultSetPrototype);
        };
        $anzeigeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Anzeige());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Anzeige());
            return new TableGateway('anzeige_new', $dbAdapter, null, $resultSetPrototype);
        };
        $infoscriptTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Infoscript());
//            $resultSetPrototype = new ResultSet();
//            $resultSetPrototype->setArrayObjectPrototype(new Entity\Infoscript());
            return new TableGateway('nachrichten_portale', $dbAdapter, null, $resultSetPrototype);
        };

        return array(
            'UrlTableGateway'                            => $urlTableGateway,
            'KundeTableGateway'                          => $kundeTableGateway,
            'PositionTableGateway'                       => $positionTableGateway,
            'AnzeigeTableGateway'                        => $anzeigeTableGateway,
            'InfoscriptTableGateway'                     => $infoscriptTableGateway,
        );
    }
    private function getTableFactories(){
        $urlTable        = function($sm) {
            $tableGateway = $sm->get('UrlTableGateway');
            $table = new Table\Url($tableGateway);
            return $table;
        };
        $kundeTable      = function($sm) {
            $tableGateway = $sm->get('KundeTableGateway');
            $table = new Table\Kunde($tableGateway);
            return $table;
        };
        $positionTable   = function($sm) {
            $tableGateway = $sm->get('PositionTableGateway');
            $table = new Table\Position($tableGateway);
            return $table;
        };
        $anzeigeTable    = function($sm) {
            $tableGateway = $sm->get('AnzeigeTableGateway');
            $table = new Table\Anzeige($tableGateway);
            return $table;
        };
        $infoscriptTable = function($sm) {
            $tableGateway = $sm->get('InfoscriptTableGateway');
            $table = new Table\Infoscript($tableGateway);
            return $table;
        };

        return array(
            'Campustv\Model\Table\Url'             => $urlTable,
            'Campustv\Model\Table\Kunde'           => $kundeTable,
            'Campustv\Model\Table\Position'        => $positionTable,
            'Campustv\Model\Table\Anzeige'         => $anzeigeTable,
            'Campustv\Model\Table\Infoscript'      => $infoscriptTable,
        );
    }
    private function getServiceFactories(){

        return array(
                'Campustv\Service\Url'                       => '\Campustv\Service\Service\Url',

                'Campustv\Service\Kunde'                     => '\Campustv\Service\Factory\Kunde',
                'Campustv\Service\Anzeige'                   => '\Campustv\Service\Factory\Anzeige',
                'Campustv\Service\Infoscript'                => '\Campustv\Service\Factory\Infoscript',

//TODO does this has any advantage? how to give this parameters?
//                'Campustv\Service\Kunde'                     => 'Campustv\Service\Factory\Kunde',
//                'Campustv\Service\Anzeige'                   => 'Campustv\Service\Factory\Anzeige',
//                'Campustv\Service\Infoscript'                => 'Campustv\Service\Factory\Infoscript',
            );
    }
}
