<?php

namespace Campustv\Service\Service;

use Campustv\Model\ITable;

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
