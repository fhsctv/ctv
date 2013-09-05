<?php

namespace Campustv\Model\Entity;

use Campustv\Model\IEntity;

class Infoscript implements IEntity {

    const TBL_COL_ID         = 'ID';
    const TBL_COL_URL        = 'URL';
    const TBL_COL_BEGIN_DATE = 'STARTDATUM';
    const TBL_COL_END_DATE   = 'ABLAUFDATUM';

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


//    public function exchangeArray(array $data) {
//
//        $this->id          = (isset($data[self::TBL_COL_ID]))          ? (int) $data[self::TBL_COL_ID]    : null;
//        $this->url         = (isset($data[self::TBL_COL_URL]))         ? $data[self::TBL_COL_URL]         : null;
//        $this->startdatum  = (isset($data[self::TBL_COL_BEGIN_DATE]))  ? $data[self::TBL_COL_BEGIN_DATE]  : null;
//        $this->ablaufdatum = (isset($data[self::TBL_COL_END_DATE]))    ? $data[self::TBL_COL_END_DATE]    : null;
//
//        return $this;
//    }

//    public function getArrayCopy(){
//        return $this->toArray();
//    }

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

        (!$this->id)          ? : $result[self::TBL_COL_ID]          = $this->id ;
        (!$this->url)         ? : $result[self::TBL_COL_URL]         = $this->url ;
        (!$this->startdatum)  ? : $result[self::TBL_COL_BEGIN_DATE]  = $this->startdatum ;
        (!$this->ablaufdatum) ? : $result[self::TBL_COL_END_DATE]    = $this->ablaufdatum ;

        return $result;


    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }
}

?>