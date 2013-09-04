<?php

namespace CampustvTest\Model;

use Campustv\Model\Entity\Infoscript as InfoscriptModel;
use PHPUnit_Framework_TestCase;

class InfoscriptTest extends PHPUnit_Framework_TestCase {

    private $data = array(
            InfoscriptModel::TBL_COL_ID         => 1,
            InfoscriptModel::TBL_COL_URL        => 'http://www.test.de',
            InfoscriptModel::TBL_COL_BEGIN_DATE => '12.12.2012',
            InfoscriptModel::TBL_COL_END_DATE   => '13.01.2013',
        );

    public function testInfoscriptInitialState() {
        $infoscript = new InfoscriptModel();

        $this->assertNull($infoscript->getId(),          '"id" should initially be null');
        $this->assertNull($infoscript->getUrl(),         '"url" should initially be null');
        $this->assertNull($infoscript->getStartdatum(),  '"startdatum" should initially be null');
        $this->assertNull($infoscript->getAblaufdatum(), '"ablaufdatum" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {

        $infoscript = new InfoscriptModel();

        $infoscript->exchangeArray($this->data);

        $this->assertSame($this->data[InfoscriptModel::TBL_COL_ID],         $infoscript->getId(),          '"id" was not set correctly');
        $this->assertSame($this->data[InfoscriptModel::TBL_COL_URL],        $infoscript->getUrl(),         '"url" was not set correctly');
        $this->assertSame($this->data[InfoscriptModel::TBL_COL_BEGIN_DATE], $infoscript->getStartdatum(),  '"startdatum" was not set correctly');
        $this->assertSame($this->data[InfoscriptModel::TBL_COL_END_DATE],   $infoscript->getAblaufdatum(), '"ablaufdatum" was not set correctly');


    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {

        $infoscript = new InfoscriptModel();

        $infoscript->exchangeArray($this->data);
        $infoscript->exchangeArray(array());

        $this->assertNull($infoscript->getId(),          '"id" should have defaulted to null');
        $this->assertNull($infoscript->getUrl(),         '"url" should have defaulted to null');
        $this->assertNull($infoscript->getStartdatum(),  '"startdatum" should have defaulted to null');
        $this->assertNull($infoscript->getAblaufdatum(), '"ablaufdatum" should have defaulted to null');

    }

    public function testGetId(){

        $infoscript = new InfoscriptModel();
        $infoscript->exchangeArray($this->data);

        $this->assertSame($this->data[InfoscriptModel::TBL_COL_ID], $infoscript->getId());
    }

    public function testGetIdKey(){

        $infoscript = new InfoscriptModel();

        $this->assertSame(InfoscriptModel::TBL_COL_ID, $infoscript->getIdKey());
    }

    public function testGetArrayCopy(){
        $infoscript = new InfoscriptModel();
        $infoscript->exchangeArray($this->data);

        $this->assertSame($this->data, $infoscript->getArrayCopy());
    }

    public function testToDbArray(){
        $infoscript = new InfoscriptModel();
        $infoscript->exchangeArray($this->data);

        $this->assertSame($this->data, $infoscript->toDbArray());
    }

    public function testToArray(){
        $infoscript = new InfoscriptModel();
        $infoscript->exchangeArray($this->data);

        $this->assertSame($this->data, $infoscript->toArray());
    }

}
