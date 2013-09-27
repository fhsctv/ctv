<?php

namespace Administration\Service\Service;

use Administration\Service\IService;
use Administration\Model\Entity\Kunde                    as KundeModel;

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

        assert(!is_null && is_numeric($id));

        return $this->getTable()->get($id);
    }

    public function save($kunde) {

        assert(is_array($kunde) || is_a($kunde, 'Administration\Model\IEntity'));

        return $this->getTable()->save($kunde);
    }

    public function delete($id) {

        assert(!is_null($id) && is_numeric($id));

        return $this->getTable()->delete($id);
    }


}

?>
