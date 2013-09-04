<?php

namespace Campustv\Service\Service;

use Campustv\Service\IService;
use Campustv\Model\Entity\Kunde                    as KundeModel;

class Kunde extends AbstractService implements IService {




    public function __construct($enableCache = true) {
        $this->enableCache = $enableCache;
    }

    public function createModel($id = null, $name = null){
        $kundeModel       = new KundeModel();
        $kundeModel->setId($id)->setName($name);

        return $kundeModel;
    }




    public function fetchAll(){

        return $this->getTable()->fetchAll()->toArray();
    }

    public function get($id) {
        return $this->getTable()->get($id);
    }

    public function save(\Campustv\Model\IEntity $model) {
        return $this->getTable()->save($model);
    }

    public function delete($id) {
        return $this->getTable()->delete($id);
    }


}

?>
