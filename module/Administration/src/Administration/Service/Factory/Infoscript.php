<?php

namespace Administration\Service\Factory;

use Administration\Service\Service\Infoscript as InfoscriptService;

class Infoscript implements \Zend\ServiceManager\FactoryInterface {

    public function __construct($enableCache = false) {
        $this->enableCache = $enableCache;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $infoscriptService = new InfoscriptService();
        $infoscriptService->setTable($sm->get('Administration\Model\Table\Infoscript'));
        $infoscriptService->setFormFactory($sm->get('Administration\Form\Factory\Infoscript'));

        return $infoscriptService;
    }

}

?>
