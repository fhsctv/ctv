<?php

namespace Administration\Service\Factory;

use Administration\Service\Service\Anzeige as AnzeigeService;

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
        $anzeigeService->setTable($sm->get('Administration\Model\Table\Anzeige'));
        $anzeigeService->setUrlTable($sm->get('Administration\Model\Table\Url'));

        $anzeigeService->setPositions($array_transform($sm->get('Administration\Model\Table\Position'), 'id', 'bezeichnung'));
//        $anzeigeService->setPositions(array('1' => 'Hoersaal', '21' => 'Mensa', '41' => 'Büro'));

        $anzeigeService->setCustomers($array_transform($sm->get('Administration\Service\Kunde'), 'par_id', 'par_name'));


        return $anzeigeService;
    }

}

?>
