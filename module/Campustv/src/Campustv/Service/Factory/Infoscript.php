<?php

namespace Campustv\Service\Factory;

use Campustv\Service\Service\Infoscript as InfoscriptService;
use Campustv\Service\Cache\Infoscript as InfoscriptServiceCache;

class Infoscript implements \Zend\ServiceManager\FactoryInterface {

    protected $enableCache = false;

    public function __construct($enableCache = false) {
        $this->enableCache = $enableCache;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $infoscriptService = new InfoscriptService();
        $infoscriptService->setTable($sm->get('Campustv\Model\Table\Infoscript'));
        $infoscriptService->setHydrator($sm->get('hydrator'));

        if (!$this->enableCache) {
            return $infoscriptService;
        }

        $infoscriptServiceCache = new InfoscriptServiceCache();
        $infoscriptServiceCache->setService($infoscriptService);
        $infoscriptServiceCache->setCache($sm->get('Zend\Cache\Storage\Filesystem'));

        return $infoscriptServiceCache;
    }

}

?>
