<?php

namespace Campustv\Model\Entity;

use Campustv\Model\IEntity;

class Position implements IEntity {

    const TBL_COL_ID          = 'id';
    const TBL_COL_NAME        = 'bezeichnung';
    const TBL_COL_POSITION_ID = 'standort_id';

    private $id;
    private $bezeichnung;
    private $standort_id;

    public function getBezeichnung() {
        return $this->bezeichnung;
    }

    public function setBezeichnung($bezeichnung) {
        $this->bezeichnung = $bezeichnung;
        return $this;
    }

    public function getStandortId() {
        return $this->standort_id;
    }

    public function setStandortId($standortId) {
        $this->standort_id = $standortId;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }


    /*
     * -------------------------------------------------------------------------
     * @todo
     * Die Spalte STANDORT_ID der TABELLE POSITION scheint redundant zu sein.
     * Wenn sie im ganzen Projekt nirgends verwendet wird, wäre es sinnvoll sie
     * zu löschen.
     * -------------------------------------------------------------------------
     */
    public function exchangeArray(array $data) {
        $this->id          = (isset($data[self::TBL_COL_ID]))           ? $data[self::TBL_COL_ID]           : null;
        $this->bezeichnung = (isset($data[self::TBL_COL_NAME]))         ? $data[self::TBL_COL_NAME]         : null;
        $this->standort_id = (isset($data[self::TBL_COL_POSITION_ID]))  ? $data[self::TBL_COL_POSITION_ID]  : null;
    }

    public function getArrayCopy(){
        return $this->toArray();
    }

    public function toArray(){
        return array(
          self::TBL_COL_ID          => $this->id,
          self::TBL_COL_NAME        => $this->bezeichnung,
          self::TBL_COL_POSITION_ID => $this->standort_id
        );
    }



    public function getIdKey() {
        return self::TBL_COL_ID;
    }

    public function toDbArray() {
        return $this->toArray();
    }
}

?>
