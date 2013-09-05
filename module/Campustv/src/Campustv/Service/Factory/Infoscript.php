<?php

namespace Campustv\Service\Factory;

use Campustv\Service\Service\Infoscript as InfoscriptService;
use Campustv\Service\Cache\Infoscript as InfoscriptServiceCache;

class Infoscript implements \Zend\ServiceManager\FactoryInterface {

    public function __construct($enableCache = false) {
        $this->enableCache = $enableCache;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $infoscriptService = new InfoscriptService();
        $infoscriptService->setTable($sm->get('Campustv\Model\Table\Infoscript'));
        $infoscriptService->setFormFactory($sm->get('Campustv\Form\Factory\Infoscript'));

        $cache = $sm->get('config')['constants']['Campustv\ServiceCaching'];

        if (!$cache) {
            return $infoscriptService;
        }

        $infoscriptServiceCache = new InfoscriptServiceCache();
        $infoscriptServiceCache->setService($infoscriptService);
        $infoscriptServiceCache->setCache($sm->get('Zend\Cache\Storage\Filesystem'));

        return $infoscriptServiceCache;
    }

}

?>
