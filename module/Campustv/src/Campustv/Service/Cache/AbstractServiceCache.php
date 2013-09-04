<?php

namespace Campustv\Service\Cache;

use \Zend\Cache\Storage\StorageInterface;
use Campustv\Service\IService;


abstract class AbstractServiceCache implements IService {

    private $service;


    public function setService(IService $service){
        $this->service = $service;
    }


    public function getService(){
        return $this->service;
    }




    private $cache;


    public function getCache(){

        if(!$this->cache)
            throw new \RuntimeException("CACHE NOT SET");

        return $this->cache;
    }


    public function setCache(StorageInterface $cache){
        $this->cache = $cache;
    }

}

?>
