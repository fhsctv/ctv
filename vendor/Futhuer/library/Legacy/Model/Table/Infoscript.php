<?php

namespace Futhuer\Legacy\Model\Table;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
//use Zend\Db\Sql\Expression;

use Futhuer\Legacy\Model\Entity as Entity;


class Infoscript extends AbstractTable {


    /**
     *
     * @param \Zend\Db\TableGateway\TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }



    /**
     * fetchAllActive fetches all rows from database table
     * taking into account the starting and enddate
     * @param int $display
     * @return array
     */
    public function fetchAllActive(){

        return $this->tableGateway->select(
            function(Select $select) {

                $select->where(Entity\Infoscript::TBL_COL_BEGIN_DATE . '<=' . self::ORACLE_TODAY_STRING);
                $select->where(Entity\Infoscript::TBL_COL_END_DATE   . '>='  . self::ORACLE_TODAY_STRING);

                $select = $this->getColumns($select);
            }
        );
    }





    public function getIdKey() {
        return Entity\Infoscript::TBL_COL_ID;
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
//        $oracleDateFormat = '\'DD.MM.YYYY\'';

        return $select->columns(array(Entity\Infoscript::TBL_COL_ID
//                                  ,Entity\Infoscript::TBL_COL_URL
//                                  ,Entity\Infoscript::TBL_COL_BEGIN_DATE
//                                    => new Expression('to_char(' . Entity\Infoscript::TBL_COL_BEGIN_DATE . ',' . $oracleDateFormat . ')')
//                                  ,Entity\Infoscript::TBL_COL_END_DATE
//                                    => new Expression('to_char(' . Entity\Infoscript::TBL_COL_END_DATE   . ',' . $oracleDateFormat . ')')
            )
        );
    }

    protected function getJoin(Select $select) {
        return $select;
    }

}

?>
