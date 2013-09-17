<?php

namespace Administration\Model\Entity;

use Administration\Model\IEntity;

class Url implements IEntity {

    const TBL_COL_ID  = 'id';
    const TBL_COL_URL = 'url';

    private $id;
    private $url;

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }


    public function exchangeArray(array $data) {
        $this->id  = (isset($data[self::TBL_COL_ID]))  ? (int) $data[self::TBL_COL_ID]  : null;
        $this->url = (isset($data[self::TBL_COL_URL])) ? $data[self::TBL_COL_URL]       : null;
    }

    public function getArrayCopy(){

        return $this->toArray();
    }

    public function toArray(){

        return array(
          self::TBL_COL_ID    => $this->id,
          self::TBL_COL_URL   => $this->url,
        );
    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }

    public function toDbArray() {
        $result = array();

        (!$this->id)  ? : $result[self::TBL_COL_ID]  = $this->id ;
        (!$this->url) ? : $result[self::TBL_COL_URL] = $this->url ;

        return $result;
    }
}

?>
