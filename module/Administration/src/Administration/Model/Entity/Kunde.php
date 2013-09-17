<?php

namespace Administration\Model\Entity;

use Administration\Model\IEntity;

class Kunde implements IEntity {

    const TBL_COL_ID       = 'par_id';
    const TBL_COL_CUSTOMER = 'par_name';

    private $id;
    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        assert(is_string($name), __METHOD__ . ' Name must be a string!');

        $this->name = $name;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {

        $id = (int) $id;
        assert(is_int($id), __METHOD__ . 'id must be an integer');

        $this->id = $id;
        return $this;
    }



    public function exchangeArray(array $data) {
        $this->id   = (isset($data[self::TBL_COL_ID]))       ? (int) $data[self::TBL_COL_ID]  : null;
        $this->name = (isset($data[self::TBL_COL_CUSTOMER])) ? $data[self::TBL_COL_CUSTOMER]  : null;

        return $this;
    }

    public function getArrayCopy(){

        return $this->toArray();
    }

    public function toArray(){

        return array(
          self::TBL_COL_ID       => $this->id,
          self::TBL_COL_CUSTOMER => $this->name,
        );
    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }

    public function toDbArray() {
        throw new \Exception(__METHOD__ . 'NOT USED'); //because Kunde read only
    }


}

?>
