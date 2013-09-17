<?php

namespace Administration\Service\Service;

use Administration\Service\IService;
use Administration\Model\IEntity         as IEntity;
use Administration\Model\Entity\Url      as UrlModel;

class Url implements \Zend\ServiceManager\FactoryInterface, IService{

    public $urlTable;

    public function getUrlModel($id = null, $url = null){
        $urlModel      = new UrlModel();

        return $urlModel->setId($id)->setUrl($url);
    }


    public function fetchAll(){
        return $this->getUrlTable()->fetchAll();
    }

    public function save(IEntity $urlModel){
        return $this->getUrlTable()->save($urlModel);
    }

    public function delete($id){
        return $this->getUrlTable()->delete( (int) $id );
    }


    public function getUrlTable(){
        return $this->urlTable;
    }

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $sm) {

        $this->urlTable = $sm->get('Administration\Model\Table\Url');

        return $this;
    }

    /**
     * @todo implement
     * @param int $id
     * @throws \Exception
     */
    public function get($id) {
        throw new \Exception("NOT IMPLEMENTED YET!");
    }
}

?>
