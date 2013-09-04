<?php

namespace Futhuer;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Futhuer\Legacy\Model\Table;
use Futhuer\Legacy\Model\Entity;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/library/',
                ),
            ),
        );
    }

    public function getServiceConfig() {


        $aktAnzeigeTable = function($sm) {
            return new Table\AktAnzeige($sm->get('AktAnzeigeTableGateway'));
        };
        $aktAnzeigeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\AktAnzeige());
            return new TableGateway('AKTUELLE_ANZEIGEN_NEW', $dbAdapter, null, $resultSetPrototype);
        };


        $infoscriptTable = function($sm) {
            $tableGateway = $sm->get('Futhuer\Legacy\InfoscriptTablegateway');
            $table = new Table\Infoscript($tableGateway);
            return $table;
        };
        $infoscriptTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Infoscript());
            return new TableGateway('NACHRICHTEN_PORTALE', $dbAdapter, null, $resultSetPrototype);
        };

        $anzeigeTable    = function($sm) {
            $tableGateway = $sm->get('Futhuer\Legacy\AnzeigeTablegateway');
            $table = new Table\Anzeige($tableGateway);
            return $table;
        };
        $anzeigeTableGateway = function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Entity\Anzeige());
            return new TableGateway('ANZEIGE_NEW', $dbAdapter, null, $resultSetPrototype);
        };

        return array(
            'factories' => array(

                'Futhuer\Legacy\Model\Table\AktAnzeige' => $aktAnzeigeTable,
                'AktAnzeigeTableGateway'                => $aktAnzeigeTableGateway,

                'Futhuer\Legacy\InfoscriptTablegateway' => $infoscriptTableGateway,
                'Futhuer\Legacy\Model\Table\Infoscript' => $infoscriptTable,

                'Futhuer\Legacy\AnzeigeTablegateway'    => $anzeigeTableGateway,
                'Futhuer\Legacy\Model\Table\Anzeige'    => $anzeigeTable,
            ),
        );
    }
}
