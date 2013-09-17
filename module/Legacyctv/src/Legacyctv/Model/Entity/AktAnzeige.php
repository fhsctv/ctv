<?php

namespace Legacyctv\Model\Entity;

use Legacyctv\Model;

class AktAnzeige implements Model\IEntity {

    const TBL_COL_ID                    = "id";
    const TBL_COL_POSITIONS_ID          = "positions_id";
    const TBL_COL_ANZAHL_WIEDERHOLUNGEN = "anzahl_wiederholungen";
    const TBL_COL_ANZEIGE_ID            = "anzeige_id";
    const TBL_COL_NEWS_ID               = "news_id";


    protected $id;
    protected $positions_id;
    protected $anzahl_wiederholungen;
    protected $anzeige_id;
    protected $news_id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getPositions_id() {
        return $this->positions_id;
    }

    public function setPositionId($positions_id) {
        $this->positions_id = $positions_id;
        return $this;
    }

    public function getAnzahlWiederholungen() {
        return $this->anzahl_wiederholungen;
    }

    public function setAnzahlWiederholungen($anzahl_wiederholungen) {
        $this->anzahl_wiederholungen = $anzahl_wiederholungen;
        return $this;
    }

    public function getAnzeigeId() {
        return $this->anzeige_id;
    }

    public function setAnzeigeId($anzeige_id) {
        $this->anzeige_id = $anzeige_id;
        return $this;
    }

    public function getNewsId() {
        return $this->news_id;
    }

    public function setNewsId($news_id) {
        $this->news_id = $news_id;
        return $this;
    }

    public function exchangeArray(array $data) {
        $this->id                     = (isset($data[self::TBL_COL_ID]))                     ? (int) $data[self::TBL_COL_ID]                     : null;
        $this->positions_id           = (isset($data[self::TBL_COL_POSITIONS_ID]))           ? (int) $data[self::TBL_COL_POSITIONS_ID]           : null;
        $this->anzahl_wiederholungen  = (isset($data[self::TBL_COL_ANZAHL_WIEDERHOLUNGEN]))  ? (int) $data[self::TBL_COL_ANZAHL_WIEDERHOLUNGEN]  : null;
        $this->anzeige_id             = (isset($data[self::TBL_COL_ANZEIGE_ID]))             ? (int) $data[self::TBL_COL_ANZEIGE_ID]             : null;
        $this->news_id                = (isset($data[self::TBL_COL_NEWS_ID]))                ? (int) $data[self::TBL_COL_NEWS_ID]                : null;

    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getIdKey() {
        return self::TBL_COL_ID;
    }

    public function toArray() {
        return $this->getArrayCopy();
    }

    public function toDbArray() {
        return $this->getArrayCopy();
    }







}

?>
