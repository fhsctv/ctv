<?php

namespace AdministrationTest\Model;

use Administration\Model\Entity\Url as UrlModel;
use PHPUnit_Framework_TestCase;

class UrlTest extends PHPUnit_Framework_TestCase {

    private $data = array(
            UrlModel::TBL_COL_ID         => 1,
            UrlModel::TBL_COL_URL        => 'http://www.test.de',
        );

    public function testUrlInitialState() {
        $url = new UrlModel();

        $this->assertNull($url->getId(),          '"id" should initially be null');
        $this->assertNull($url->getUrl(),         '"url" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {

        $url = new UrlModel();

        $url->exchangeArray($this->data);

        $this->assertSame($this->data[UrlModel::TBL_COL_ID],         $url->getId(),          '"id" was not set correctly');
        $this->assertSame($this->data[UrlModel::TBL_COL_URL],        $url->getUrl(),         '"url" was not set correctly');


    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {

        $url = new UrlModel();

        $url->exchangeArray($this->data);
        $url->exchangeArray(array());

        $this->assertNull($url->getId(),          '"id" should have defaulted to null');
        $this->assertNull($url->getUrl(),         '"url" should have defaulted to null');
    }

    public function testGetId(){

        $url = new UrlModel();
        $url->exchangeArray($this->data);

        $this->assertSame($this->data[UrlModel::TBL_COL_ID], $url->getId());
    }

    public function testGetIdKey(){

        $url = new UrlModel();

        $this->assertSame(UrlModel::TBL_COL_ID, $url->getIdKey());
    }

    public function testGetArrayCopy(){
        $url = new UrlModel();
        $url->exchangeArray($this->data);

        $this->assertSame($this->data, $url->getArrayCopy());
    }

    public function testToDbArray(){
        $url = new UrlModel();
        $url->exchangeArray($this->data);

        $this->assertSame($this->data, $url->toDbArray());
    }

    public function testToDbArrayWithNullValues(){
        $data1 = array(UrlModel::TBL_COL_URL => 'http://www.debug.de');
        $data2 = array(UrlModel::TBL_COL_ID => 17);

        $url = new UrlModel();

        $url->exchangeArray($data1);
        $this->assertSame($data1, $url->toDbArray());


        $url->exchangeArray($data2);
        $this->assertSame($data2, $url->toDbArray());
    }

    public function testToArray(){
        $url = new UrlModel();
        $url->exchangeArray($this->data);

        $this->assertSame($this->data, $url->toArray());
    }

}
