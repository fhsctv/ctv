<?php

namespace Administration\Service\Service;

use Administration\Model\ITable;

class AbstractService {

    private $table;


    public function getTable(){
        return $this->table;
    }

    public function setTable(ITable $table) {
        $this->table = $table;
    }




}

?>
