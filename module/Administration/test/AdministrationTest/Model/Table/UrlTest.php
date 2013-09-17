<?php

namespace AdministrationTest\Model\Table;

use PHPUnit_Framework_TestCase;
use Zend\Db\ResultSet\ResultSet;
use Administration\Model\Entity\Url       as UrlModel;
use Administration\Model\Table\Url as UrlTable;

class UrlTest extends PHPUnit_Framework_TestCase {


    /**
     *
     * @link http://framework.zend.com/manual/2.0/en/user-guide/database-and-models.html
     * @link http://www.admin-wissen.de/tutorials/php_tutorial/fortgeschrittene/testgetriebene_entwicklung/mocks.html
     */
    public function testCanRetrieveUrlByItsId() {

        $url = new UrlModel();
        $url->exchangeArray(array(
                UrlModel::TBL_COL_ID => '15',
                UrlModel::TBL_COL_URL => 'http://www.debug.org',
            )
        );

        $resultSet = $this->getExpectedResultSet($url);
        $mockTableGateway = $this->getSelectMock($resultSet);

        $urlTable = new UrlTable($mockTableGateway);

        $this->assertEquals($url, $urlTable->get(15));
    }

    public function testCanDeleteAnUrlByItsId(){
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('delete')
                         ->with(array(UrlModel::TBL_COL_ID => 123));

        $urlTable = new UrlTable($mockTableGateway);
        $urlTable->delete(123);
    }

    public function testSaveUrlWillInsertNewUrlsIfTheyDontAlreadyHaveAnId(){

        $urlData = array(UrlModel::TBL_COL_URL => 'http://www.debug.org');
        $url     = new UrlModel();
        $url->exchangeArray($urlData);


        $resultSet = $this->getExpectedResultSet($url);
        $mockTableGateway = $this->getInsertMock($urlData, $resultSet);

        $urlTable = new UrlTable($mockTableGateway);
        $urlTable->save($url);
    }

    public function testSaveAlbumWillUpdateExistingUrlsIfTheyAlreadyHaveAnId(){

        $urlData = array(UrlModel::TBL_COL_ID => 123, UrlModel::TBL_COL_URL => 'http://www.debug.de');
        $url     = new UrlModel();
        $url->exchangeArray($urlData);

        $resultSet = $this->getExpectedResultSet($url);

        $mockTableGateway = $this->getUpdateMock($this->getSelectMock($resultSet), $urlData, array(UrlModel::TBL_COL_ID => 123));

        $urlTable = new UrlTable($mockTableGateway);
        $urlTable->save($url);


    }

    public function testExceptionIsThrownWhenGettingNonexistentUrl(){

        $resultSet = $this->getExpectedResultSet();
        $mockTableGateway = $this->getSelectMock($resultSet);

        $urlTable = new UrlTable($mockTableGateway);

        try
        {
            $urlTable->get(123);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 123', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }

    public function testExceptionIsThrownWhenUrlNotHavingSetUrlAttribute(){

        $urlData = array(UrlModel::TBL_COL_ID => 123);
        $url = new UrlModel();
        $url->exchangeArray($urlData);

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array(), array(), '', false);
        $urlTable = new UrlTable($mockTableGateway);


        try{
            $urlTable->save($url);
        }
        catch (\Exception $e){
            $this->assertSame('Url is required for saving Url!', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }


    private function getSelectMock($resultSet){

        $closure = function() use ($resultSet){
            //this closure returns just the result
            //here you don't care about the Select $select parameter like in
            //AbstractTable, because the database functions are sufficiently
            //tested by zend developers
            return $resultSet;
        };

        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select','update'), array(), '', false);

        $mockTableGateway
                ->expects($this->once())                 //expects one single call of the select method
                ->method('select')                       //expects the call of the method select
                ->with($closure)                         //parameter of select method is a closure
                ->will($this->returnCallback($closure)); //simulates the return of the result of the closure

        return $mockTableGateway;
    }

    private function getUpdateMock($mockTableGateway, $urlData, $id){

        $mockTableGateway->expects($this->once())
                         ->method('update')
                         ->with($urlData, $id);

        return $mockTableGateway;
    }

    private function getInsertMock($urlData, $resultSet){
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('select','insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('insert')
                         ->with($urlData);

        $closure = function() use ($resultSet){
            //this closure returns just the result
            //here you don't care about the Select $select parameter like in
            //AbstractTable, because the database functions are sufficiently
            //tested by zend developers
            return $resultSet;
        };

//        $mockTableGateway
//                ->expects($this->once())                 //expects one single call of the select method
//                ->method('select')                       //expects the call of the method select
//                ->with($closure)                         //parameter of select method is a closure
//                ->will($this->returnCallback($closure)); //simulates the return of the result of the closure

        return $mockTableGateway;
    }

    private function getExpectedResultSet($url = null){
        $resultSet = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new UrlModel());

        if($url)
            $resultSet->initialize(array($url));
        else
            $resultSet->initialize(array());

        return $resultSet;
    }

}
