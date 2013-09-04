<?php

namespace Campustv;


use Campustv\Model\Entity    as Entity;
use Campustv\Model\Table     as Table;
use Campustv\Service\Factory as ServiceFactory;


use Campustv\Service\Service\Url          as UrlService;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module {

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
                $this->getGatewayFactories(),
                $this->getTableFactories(),
                $this->getServiceFactories()
//                ,array('hydrator' => function(){return new \Zend\Stdlib\Hydrator\ClassMethods; })
            )
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
            return new TableGateway('URL', $dbAdapter, null, $resultSetPrototype);
        };
        $kundeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Kunde());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Kunde());
            return new TableGateway('TBL_PARTNER', $dbAdapter, null, $resultSetPrototype);
        };
        $positionTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Position());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Position());
            return new TableGateway('POSITION', $dbAdapter, null, $resultSetPrototype);
        };
        $anzeigeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Anzeige());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Anzeige());
            return new TableGateway('ANZEIGE_NEW', $dbAdapter, null, $resultSetPrototype);
        };
        $infoscriptTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//            $resultSetPrototype = new HydratingResultSet($sm->get('hydrator'), new Entity\Infoscript());
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Infoscript());
            return new TableGateway('NACHRICHTEN_PORTALE', $dbAdapter, null, $resultSetPrototype);
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
                'Campustv\Service\Url'                       => new UrlService(self::MODEL_CACHING),
                'Campustv\Service\Kunde'                     => new ServiceFactory\Kunde(self::MODEL_CACHING),
                'Campustv\Service\Anzeige'                   => new ServiceFactory\Anzeige(self::MODEL_CACHING),
                'Campustv\Service\Infoscript'                => new ServiceFactory\Infoscript(self::MODEL_CACHING),

//TODO does this has any advantage? how to give this parameters?
//                'Campustv\Service\Kunde'                     => 'Campustv\Service\Factory\Kunde',
//                'Campustv\Service\Anzeige'                   => 'Campustv\Service\Factory\Anzeige',
//                'Campustv\Service\Infoscript'                => 'Campustv\Service\Factory\Infoscript',
            );
    }
}