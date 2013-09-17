<?php

namespace Legacyctv\Model\Entity;

use Legacyctv\Model;

class Zeitzone implements Model\IEntity {

    const TBL_COL_ID       = 'id';
    const TBL_COL_NAME     = 'bezeichnung';
    const TBL_COL_POSITION = 'standort_id';
    const TBL_COL_BEGIN    = 'von';
    const TBL_COL_END      = 'bis';

    public $id;
    public $name;
    public $position;
    public $begin;
    public $end;



    public function exchangeArray(array $data) {

        $this->id       = (isset($data[self::TBL_COL_ID]))       ? (int) $data[self::TBL_COL_ID] : null;
        $this->name     = (isset($data[self::TBL_COL_NAME]))     ? $data[self::TBL_COL_NAME]     : null;
        $this->position = (isset($data[self::TBL_COL_POSITION])) ? $data[self::TBL_COL_POSITION] : null;
        $this->begin    = (isset($data[self::TBL_COL_BEGIN]))    ? $data[self::TBL_COL_BEGIN]    : null;
        $this->end      = (isset($data[self::TBL_COL_END]))      ? $data[self::TBL_COL_END]      : null;
    }

    public function getArrayCopy(){
        return $this->toArray();
    }

    public function toArray(){
        return array(
            self::TBL_COL_ID       => $this->id,
            self::TBL_COL_NAME     => $this->name,
            self::TBL_COL_POSITION => $this->position,
            self::TBL_COL_BEGIN    => $this->begin,
            self::TBL_COL_END      => $this->end,
            );
    }

    public function toDbArray() {

        $result = array();

        (!$this->id)       ? : $result[self::TBL_COL_ID]       = $this->id ;
        (!$this->name)     ? : $result[self::TBL_COL_NAME]     = $this->name ;
        (!$this->position) ? : $result[self::TBL_COL_POSITION] = $this->position ;
        (!$this->begin)    ? : $result[self::TBL_COL_BEGIN]    = $this->begin ;
        (!$this->end)      ? : $result[self::TBL_COL_END]      = $this->end ;

        return $result;


    }

    public function getId() {
        return $this->id;
    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }
}

?>