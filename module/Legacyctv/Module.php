<?php

namespace Legacyctv;

//use Zend\Mvc\ModuleRouteListener;
//use Zend\Mvc\MvcEvent;

use Legacyctv\Model\Table;
use Legacyctv\Model\Entity;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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

    public function getServiceConfig() {


        $zeitzoneTable = function($sm) {
            return new Table\Zeitzone($sm->get('ZeitzoneTableGateway'));
        };

        $zeitzoneTableGateway = function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entity\Zeitzone());
                    return new TableGateway('ZEITZONEN', $dbAdapter, null, $resultSetPrototype);
                };

        $aktAnzeigeTable = function($sm) {
            return new Table\AktAnzeige($sm->get('AktAnzeigeTableGateway'));
        };

        $aktAnzeigeTableGateway = function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Entity\AktAnzeige());
                    return new TableGateway('AKTUELLE_ANZEIGEN_NEW', $dbAdapter, null, $resultSetPrototype);
                };

        return array(
            'factories' => array(

                'Legacyctv\Model\Table\Zeitzone'        => $zeitzoneTable,
                'ZeitzoneTableGateway'                  => $zeitzoneTableGateway,

                'Legacyctv\Model\Table\AktAnzeige'      => $aktAnzeigeTable,
                'AktAnzeigeTableGateway'                => $aktAnzeigeTableGateway,
            ),
        );
    }
}
