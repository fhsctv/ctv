<?php

namespace Legacyctv\Model\Table;

use Legacyctv\Model;
use Legacyctv\Model\Entity;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class Zeitzone extends AbstractTable {


    /**
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);
    }

    public function fetchAllByDisplay($position) {
        return $this->tableGateway->select(
            function(Select $select) use ($position) {

                $select->where(Entity\Zeitzone::TBL_COL_POSITION . '=' . $position);

                $select = $this->getColumns($select);

                $select->order(Entity\Zeitzone::TBL_COL_BEGIN);

//               echo $select->getSqlString();
            }
        );
    }

    public function getZeitzone($id) {
        return parent::getRow($id);
    }

    public function saveZeitzone(Model\IEntity $zeitzone) {

        parent::saveRow($zeitzone);
    }

    public function deleteZeitzone($id){
        parent::deleteRow($id);
    }


    /**
     * This specifies the datatypes of the columns.
     * For example the date- format of a date- typed column can be
     * specified to have the format 'DD.MM.YYYY' instead of the standard format
     * 'DD.MM.YY'
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\Sql\Select
     */
    protected function getColumns(Select $select){

        return $select;
    }

    public function getIdKey() {
        return InfoscriptModel::TBL_COL_ID;
    }

    protected function getJoin(Select $select) {
        return $select;
    }

}

?>
