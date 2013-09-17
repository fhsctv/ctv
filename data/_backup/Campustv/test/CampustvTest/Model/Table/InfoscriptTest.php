<?php

namespace CampustvTest\Model\Table;

use PHPUnit_Framework_TestCase;
use Zend\Db\ResultSet\HydratingResultSet;

use CampustvTest\Bootstrap;

use Campustv\Model\Entity\Infoscript            as InfoscriptModel;
use Campustv\Model\Table\Infoscript             as InfoscriptTable;

class InfoscriptTest extends PHPUnit_Framework_TestCase {



    private $hydrator;

    public function __construct(){
        $this->hydrator = Bootstrap::getServiceManager()->get('hydrator');
    }

    /**
     *
     * @link http://framework.zend.com/manual/2.0/en/user-guide/database-and-models.html
     * @link http://www.admin-wissen.de/tutorials/php_tutorial/fortgeschrittene/testgetriebene_entwicklung/mocks.html
     */
    public function testCanRetrieveInfoscriptByItsId(){

        $data = array(
            InfoscriptModel::TBL_COL_ID => 15,
            InfoscriptModel::TBL_COL_URL => 'http://www.debug.org',
            InfoscriptModel::TBL_COL_BEGIN_DATE => '03.05.2013',
            InfoscriptModel::TBL_COL_END_DATE => '04.05.2013',
        );

        $infoscript = $this->hydrator->hydrate($data, new InfoscriptModel());

        $resultSet = $this->getExpectedResultSet($data);
        $mockTableGateway = $this->getSelectMock($resultSet);

        $infoscriptTable = new InfoscriptTable($mockTableGateway);

        $this->assertEquals($infoscript, $infoscriptTable->get(15));
    }

    public function testCanDeleteAnInfoscriptByItsId(){
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('delete')
                         ->with(array(InfoscriptModel::TBL_COL_ID => 123));

        $infoscriptTable = new InfoscriptTable($mockTableGateway);
        $infoscriptTable->delete(123);
    }

    public function testSaveInfoscriptWillInsertNewInfoscriptsIfTheyDontAlreadyHaveAnId(){

        $data = array(
            InfoscriptModel::TBL_COL_URL        => 'http://www.debug.org',
            InfoscriptModel::TBL_COL_BEGIN_DATE => '03.05.2013',
            InfoscriptModel::TBL_COL_END_DATE   => '04.05.2013',
        );
        $infoscript = $this->hydrator->hydrate($data, new InfoscriptModel());

        $mockTableGateway = $this->getInsertMock($data);

        $infoscriptTable = new InfoscriptTable($mockTableGateway);
        $infoscriptTable->save($infoscript);
    }

    public function testSaveAlbumWillUpdateExistingInfoscriptsIfTheyAlreadyHaveAnId(){

        $data = array(
            InfoscriptModel::TBL_COL_ID         => 123,
            InfoscriptModel::TBL_COL_URL        => 'http://www.debug.org',
            InfoscriptModel::TBL_COL_BEGIN_DATE => '03.05.2013',
            InfoscriptModel::TBL_COL_END_DATE   => '04.05.2013',
        );

        $infoscript = $this->hydrator->hydrate($data, new InfoscriptModel());

        $resultSet = $this->getExpectedResultSet($data);

        $mockTableGateway = $this->getUpdateMock($this->getSelectMock($resultSet), $data, array(InfoscriptModel::TBL_COL_ID => 123));

        $infoscriptTable = new InfoscriptTable($mockTableGateway);
        $infoscriptTable->save($infoscript);
    }

    public function testExceptionIsThrownWhenGettingNonexistentInfoscript(){

        $resultSet        = $this->getExpectedResultSet();
        $mockTableGateway = $this->getSelectMock($resultSet);

        $infoscriptTable = new InfoscriptTable($mockTableGateway);

        try
        {
            $infoscriptTable->get(123);
        }
        catch (\Exception $e)
        {
            $this->assertSame('Could not find row 123', $e->getMessage());
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

    private function getUpdateMock($mockTableGateway, $infoscriptData, $id){

        $mockTableGateway->expects($this->once())
                         ->method('update')
                         ->with($infoscriptData, $id);

        return $mockTableGateway;
    }

    private function getInsertMock($infoscriptData){
        $mockTableGateway = $this->getMock('Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false);
        $mockTableGateway->expects($this->once())
                         ->method('insert')
                         ->with($infoscriptData);

        return $mockTableGateway;
    }

    private function getExpectedResultSet($data = null){
        $resultSet = new HydratingResultSet($this->hydrator, new InfoscriptModel());

        if($data)
            $resultSet->initialize(array($data));
        else
            $resultSet->initialize(array());

        return $resultSet;
    }

}
