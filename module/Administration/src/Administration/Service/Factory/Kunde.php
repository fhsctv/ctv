<?php

namespace Administration\Service\Factory;

use Administration\Service\Service\Kunde as KundeService;

class Kunde implements \Zend\ServiceManager\FactoryInterface {

    protected $enableCache = false;

    public function __construct($enableCache = false) {
        $this->enableCache = $enableCache;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $kundeService = new KundeService();
        $kundeService->setTable($sm->get('Administration\Model\Table\Kunde'));

        return $kundeService;
    }
}

?>
