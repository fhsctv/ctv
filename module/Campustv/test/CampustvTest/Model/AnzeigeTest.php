<?php

namespace CampustvTest\Model;

use Campustv\Model\Entity\Anzeige as AnzeigeModel;
use PHPUnit_Framework_TestCase;

class AnzeigeTest extends PHPUnit_Framework_TestCase {


    private $data = array(
        AnzeigeModel::TBL_COL_ID           => '7895',
        AnzeigeModel::TBL_COL_BEGIN_DATE   => '01.01.2013',
        //AnzeigeModel::TBL_COL_END_DATE     => '29.01.2013',   // is BEGIN_DATE + BOOKED_WEEKS
        AnzeigeModel::TBL_COL_PROPABILITY  => 7,
        AnzeigeModel::TBL_COL_SEARCH_ID    => 81,
        AnzeigeModel::TBL_COL_CUSTOMER_ID  => 13131313,
        AnzeigeModel::TBL_COL_DISPLAY_ID   => 15,
        AnzeigeModel::TBL_COL_INSIDE_CART  => 0,
        AnzeigeModel::TBL_COL_BOOKED_WEEKS => 4,
        AnzeigeModel::TBL_COL_URL          => 'http://www.test.de',      //TABLE URL
        AnzeigeModel::TBL_COL_CUSTOMER     => 'FuThuer Company',         //TABLE TBL_PARTNER
    );

    public function testAnzeigeInitialState() {
        $anzeige = new AnzeigeModel();

        $this->assertNull($anzeige->getId(),                 '"id" should initially be null');
        $this->assertNull($anzeige->getSchaltungsanfang(),   '"schaltungsanfang" should initially be null');
        $this->assertNull($anzeige->getSchaltungsende(),     '"schaltungsende" should initially be null');
        $this->assertNull($anzeige->getWahrscheinlichkeit(), '"wahrscheinlichkeit" should initially be null');
        $this->assertNull($anzeige->getSuchId(),             '"such_id" should initially be null');
        $this->assertNull($anzeige->getKundenId(),           '"kunden_id" should initially be null');
        $this->assertNull($anzeige->getPositionsId(),        '"positions_id" should initially be null');
        $this->assertNull($anzeige->getImwarenkorb(),        '"imwarenkorb" should initially be null');
        $this->assertNull($anzeige->getGebuchteWochen(),     '"gebuchte_wochen" should initially be null');
        $this->assertNull($anzeige->getUrl(),                '"url" should initially be null');
        $this->assertNull($anzeige->getParName(),            '"par_name" should initially be null');
    }

    public function testExchangeArraySetsPropertiesCorrectly() {

        $anzeige = new AnzeigeModel();

        $anzeige->exchangeArray($this->data);

        $expected = $this->data;
        $expected[AnzeigeModel::TBL_COL_END_DATE] = '29.01.2013'; // is BEGIN_DATE + BOOKED_WEEKS

        $this->assertSame($expected[AnzeigeModel::TBL_COL_ID], $anzeige->getId(),'"id" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BEGIN_DATE], $anzeige->getSchaltungsanfang(),'"schaltungsanfang" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_END_DATE], $anzeige->getSchaltungsende(),'"schaltungsende" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_PROPABILITY], $anzeige->getWahrscheinlichkeit(),'"wahrscheinlichkeit" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_SEARCH_ID], $anzeige->getSuchId(),'"such_id" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER_ID], $anzeige->getKundenId(),'"kunden_id" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_DISPLAY_ID], $anzeige->getPositionsId(),'"positions_id" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_INSIDE_CART], $anzeige->getImwarenkorb(),'"imwarenkorb" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BOOKED_WEEKS], $anzeige->getGebuchteWochen(),'"gebuchte_wochen" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_URL], $anzeige->getUrl(),'"url" was not set correctly');
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER], $anzeige->getParName(),'"par_name" was not set correctly');
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent() {

        $anzeige = new AnzeigeModel();

        $anzeige->exchangeArray($this->data);
        $anzeige->exchangeArray(array());


        $this->assertNull($anzeige->getId(),                 '"id" should have defaulted to null');
        $this->assertNull($anzeige->getSchaltungsanfang(),   '"schaltungsanfang" should have defaulted to null');
        $this->assertNull($anzeige->getSchaltungsende(),     '"schaltungsende" should have defaulted to null');
        $this->assertNull($anzeige->getWahrscheinlichkeit(), '"wahrscheinlichkeit" should have defaulted to null');
        $this->assertNull($anzeige->getSuchId(),            '"such_id" should have defaulted to null');
        $this->assertNull($anzeige->getKundenId(),          '"kunden_id" should have defaulted to null');
        $this->assertNull($anzeige->getPositionsId(),       '"positions_id" should have defaulted to null');
        $this->assertNull($anzeige->getImwarenkorb(),        '"imwarenkorb" should have defaulted to null');
        $this->assertNull($anzeige->getGebuchteWochen(),    '"gebuchte_wochen" should have defaulted to null');
        $this->assertNull($anzeige->getUrl(),                '"url" should have defaulted to null');
        $this->assertNull($anzeige->getParName(),           '"par_name" should have defaulted to null');
    }

    public function testGetId(){

        $anzeige = new AnzeigeModel();
        $anzeige->exchangeArray($this->data);

        $this->assertSame($this->data[AnzeigeModel::TBL_COL_ID], $anzeige->getId());
    }

    public function testGetIdKey(){

        $anzeige = new AnzeigeModel();

        $this->assertSame(AnzeigeModel::TBL_COL_ID, $anzeige->getIdKey());
    }

    public function testGetArrayCopy(){

        $expected = $this->data;
        $expected[AnzeigeModel::TBL_COL_END_DATE] = '29.01.2013'; // is BEGIN_DATE + BOOKED_WEEKS

        $anzeige = new AnzeigeModel();
        $anzeige->exchangeArray($this->data);

        $result = $anzeige->getArrayCopy();


        $this->assertSame($expected[AnzeigeModel::TBL_COL_ID], $result[AnzeigeModel::TBL_COL_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BEGIN_DATE], $result[AnzeigeModel::TBL_COL_BEGIN_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_END_DATE], $result[AnzeigeModel::TBL_COL_END_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_PROPABILITY], $result[AnzeigeModel::TBL_COL_PROPABILITY]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_SEARCH_ID], $result[AnzeigeModel::TBL_COL_SEARCH_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER_ID], $result[AnzeigeModel::TBL_COL_CUSTOMER_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_DISPLAY_ID], $result[AnzeigeModel::TBL_COL_DISPLAY_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_INSIDE_CART], $result[AnzeigeModel::TBL_COL_INSIDE_CART]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BOOKED_WEEKS], $result[AnzeigeModel::TBL_COL_BOOKED_WEEKS]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_URL], $result[AnzeigeModel::TBL_COL_URL]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER], $result[AnzeigeModel::TBL_COL_CUSTOMER]);
    }

    public function testToDbArray(){
        $expected = $this->data;
        $expected[AnzeigeModel::TBL_COL_END_DATE] = '29.01.2013';

        $anzeige = new AnzeigeModel();
        $anzeige->exchangeArray($this->data);

        $result = $anzeige->toDbArray();

        $this->assertSame($expected[AnzeigeModel::TBL_COL_ID], $result[AnzeigeModel::TBL_COL_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BEGIN_DATE], $result[AnzeigeModel::TBL_COL_BEGIN_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_END_DATE], $result[AnzeigeModel::TBL_COL_END_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_PROPABILITY], $result[AnzeigeModel::TBL_COL_PROPABILITY]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_SEARCH_ID], $result[AnzeigeModel::TBL_COL_SEARCH_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER_ID], $result[AnzeigeModel::TBL_COL_CUSTOMER_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_DISPLAY_ID], $result[AnzeigeModel::TBL_COL_DISPLAY_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_INSIDE_CART], $result[AnzeigeModel::TBL_COL_INSIDE_CART]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BOOKED_WEEKS], $result[AnzeigeModel::TBL_COL_BOOKED_WEEKS]);

        $this->assertFalse(isset($result[AnzeigeModel::TBL_COL_URL]));
        $this->assertFalse(isset($result[AnzeigeModel::TBL_COL_CUSTOMER]));
    }

    public function testToArray(){

        $expected = $this->data;
        $expected[AnzeigeModel::TBL_COL_END_DATE] = '29.01.2013'; // is BEGIN_DATE + BOOKED_WEEKS

        $anzeige = new AnzeigeModel();
        $anzeige->exchangeArray($this->data);

        $result = $anzeige->toArray();


        $this->assertSame($expected[AnzeigeModel::TBL_COL_ID], $result[AnzeigeModel::TBL_COL_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BEGIN_DATE], $result[AnzeigeModel::TBL_COL_BEGIN_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_END_DATE], $result[AnzeigeModel::TBL_COL_END_DATE]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_PROPABILITY], $result[AnzeigeModel::TBL_COL_PROPABILITY]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_SEARCH_ID], $result[AnzeigeModel::TBL_COL_SEARCH_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER_ID], $result[AnzeigeModel::TBL_COL_CUSTOMER_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_DISPLAY_ID], $result[AnzeigeModel::TBL_COL_DISPLAY_ID]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_INSIDE_CART], $result[AnzeigeModel::TBL_COL_INSIDE_CART]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_BOOKED_WEEKS], $result[AnzeigeModel::TBL_COL_BOOKED_WEEKS]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_URL], $result[AnzeigeModel::TBL_COL_URL]);
        $this->assertSame($expected[AnzeigeModel::TBL_COL_CUSTOMER], $result[AnzeigeModel::TBL_COL_CUSTOMER]);
    }

}
