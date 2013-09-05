<?php

namespace Campustv\Service\Factory;

use Campustv\Service\Service\Anzeige as AnzeigeService;
use Campustv\Service\Cache\Anzeige   as AnzeigeServiceCache;

class Anzeige implements \Zend\ServiceManager\FactoryInterface {

    public function __construct($enableCache = false) {
        $this->enableCache = $enableCache;
    }


    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        //TODO array_transform should take an array as argument, and not the service
        /**
         * Transforms a model array into an array containing just pairs of 'ID' => 'NAME'
         */
        $array_transform = function($service, $key, $value){
            $result = array();

            $resultArray = $service->fetchAll();

            foreach ($resultArray as $r) {
                $result[$r[$key]] = $r[$value];
            }

            return $result;
        };

        $anzeigeService = new AnzeigeService();
        $anzeigeService->setTable($sm->get('Campustv\Model\Table\Anzeige'));
        $anzeigeService->setUrlTable($sm->get('Campustv\Model\Table\Url'));

        //$anzeigeService->setPositions($array_transform($sm->get('Campustv\Model\Table\Table\Position'),'ID', 'BEZEICHNUNG'));
        $anzeigeService->setPositions(array('1' => 'Hoersaal', '21' => 'Mensa', '41' => 'Büro'));


        $anzeigeService->setCustomers($array_transform($sm->get('Campustv\Service\Kunde'),'PAR_ID', 'PAR_NAME'));


        $cache = $sm->get('config')['constants']['Campustv\ServiceCaching'];

        if (!$cache) {
            return $anzeigeService;
        }


        $anzeigeServiceCache = new AnzeigeServiceCache();
        $anzeigeServiceCache->setService($anzeigeService);
        $anzeigeServiceCache->setCache($sm->get('Zend\Cache\Storage\Filesystem'));

        return $anzeigeServiceCache;


    }
}

?>
