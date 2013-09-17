<?php

namespace Administration\Model\Entity;

use Administration\Model\IEntity;

class Infoscript implements IEntity {

    const TBL_COL_ID         = 'id';
    const TBL_COL_URL        = 'url';
    const TBL_COL_BEGIN_DATE = 'startdatum';
    const TBL_COL_END_DATE   = 'ablaufdatum';

    private $id;
    private $url;
    private $startdatum;
    private $ablaufdatum;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getStartdatum() {
        return $this->startdatum;
    }

    public function setStartdatum($startdatum) {
        $this->startdatum = $startdatum;
        return $this;
    }

    public function getAblaufdatum() {
        return $this->ablaufdatum;
    }

    public function setAblaufdatum($ablaufdatum) {
        $this->ablaufdatum = $ablaufdatum;
        return $this;
    }

    public function toArray(){
        return array(
            self::TBL_COL_ID          => $this->id,
            self::TBL_COL_URL         => $this->url,
            self::TBL_COL_BEGIN_DATE  => $this->startdatum,
            self::TBL_COL_END_DATE    => $this->ablaufdatum,
            );
    }

    public function toDbArray() {

        $result = array();

        (!isset($this->id))          ? : $result[self::TBL_COL_ID]          = $this->id ;
        (!isset($this->url))         ? : $result[self::TBL_COL_URL]         = $this->url ;
        (!isset($this->startdatum))  ? : $result[self::TBL_COL_BEGIN_DATE]  = $this->startdatum ;
        (!isset($this->ablaufdatum)) ? : $result[self::TBL_COL_END_DATE]    = $this->ablaufdatum ;

        return $result;


    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }
}

?>