<?php

namespace Administration\Service\Service;

use Administration\Model\ITable;

class AbstractService {

    private $table;
    private $hydrator;

    public function getTable(){
        return $this->table;
    }

    public function setTable(ITable $table) {
        $this->table = $table;
    }

    public function getHydrator() {
        return $this->hydrator;
    }

    public function setHydrator($hydrator) {
        $this->hydrator = $hydrator;
        return $this;
    }


}

?>
