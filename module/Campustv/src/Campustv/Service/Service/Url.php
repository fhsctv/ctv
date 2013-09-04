<?php

namespace Campustv\Service\Service;

use Campustv\Service\IService;
use Campustv\Model\IEntity         as IEntity;
use Campustv\Model\Entity\Url              as UrlModel;
use Campustv\Form\UrlForm                 as UrlForm;

class Url implements \Zend\ServiceManager\FactoryInterface, IService{

    public $urlTable;

    public function getUrlModel($id = null, $url = null){
        $urlModel      = new UrlModel();

        return $urlModel->setId($id)->setUrl($url);
    }

    public function getUrlForm(){
        return new UrlForm();
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

        $this->urlTable = $sm->get('Campustv\Model\Table\Url');

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
