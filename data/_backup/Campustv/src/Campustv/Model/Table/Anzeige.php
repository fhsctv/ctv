<?php

namespace Campustv\Model\Table;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

use Campustv\Model\IEntity;
use Campustv\Model\Entity;

class Anzeige extends AbstractTable {

    /**
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }


    /**
     * fetchAllActive fetches all rows from database table
     * taking into account the starting and end date as well as the assigned
     * display
     * @param int $display
     * @return ResultSet
     */
    public function fetchAllActive($display){

        return $this->tableGateway->select(
            function(Select $select) use ($display){


               $select = $this->getColumns($this->getJoin($select));

               $select->where(Entity\Anzeige::TBL_COL_BEGIN_DATE . '<=' . self::ORACLE_TODAY_STRING);
               $select->where(Entity\Anzeige::TBL_COL_END_DATE   . '>=' . self::ORACLE_TODAY_STRING);

               $select->order(Entity\Anzeige::TBL_COL_ID);

               if($display)
                    $select->where(Entity\Anzeige::TBL_COL_DISPLAY_ID . '=' . $display);

//               echo $select->getSqlString();
               return $select;
            }
        );
    }

    /**
     * fetchAllActive fetches all rows from database table witch are outdated
     * @param int $display
     * @return ResultSet
     */
    public function fetchAllOutdated($display){

        return $this->tableGateway->select(
            function(Select $select) use ($display) {

                $select = $this->getJoin($select);
                $select = $this->getColumns($select);

                $select->where(Entity\Anzeige::TBL_COL_END_DATE   . '<' . self::ORACLE_TODAY_STRING);

                if($display)
                    $select->where(Entity\Anzeige::TBL_COL_DISPLAY_ID . '=' . $display);

//               echo $select->getSqlString();
            }
        );
    }

    /**
     * fetchAllFuture fetches all rows from database table witch will be shown
     * in future.
     * @param int $display
     * @return ResultSet
     */
    public function fetchAllFuture($display){

        return $this->tableGateway->select(
            function(Select $select) use ($display)  {

                $select = $this->getJoin($select);
                $select = $this->getColumns($select);

                $select->where(Entity\Anzeige::TBL_COL_BEGIN_DATE   . '>' . self::ORACLE_TODAY_STRING);

                if($display)
                    $select->where(Entity\Anzeige::TBL_COL_DISPLAY_ID . '=' . $display);
//               echo $select->getSqlString();
            }
        );
    }

    protected function getJoin(Select $select){

        $select->join('url'
                     ,'url.id = ' . $this->tableGateway->getTable() . '.such_id',
                          array('url'),Select::JOIN_INNER);

        $select->join('tbl_partner'
                            ,'kunden_id = par_id'
                            ,array('par_name')
                            ,Select::JOIN_INNER);


//        var_dump($select->getSqlString());

        return $select;

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
        $dateFormat = '\'DD.MM.YYYY\'';

        return $select->columns(array(Entity\Anzeige::TBL_COL_ID
                                     ,Entity\Anzeige::TBL_COL_BOOKED_WEEKS
                                     ,Entity\Anzeige::TBL_COL_CUSTOMER_ID
                                     ,Entity\Anzeige::TBL_COL_DISPLAY_ID
                                     ,Entity\Anzeige::TBL_COL_INSIDE_CART
                                     ,Entity\Anzeige::TBL_COL_PROPABILITY
                                     ,Entity\Anzeige::TBL_COL_SEARCH_ID
                                     ,Entity\Anzeige::TBL_COL_BEGIN_DATE => new Expression('to_char(' . Entity\Anzeige::TBL_COL_BEGIN_DATE . ',' . $dateFormat . ')')
                                     ,Entity\Anzeige::TBL_COL_END_DATE   => new Expression('to_char(' . Entity\Anzeige::TBL_COL_END_DATE   . ',' . $dateFormat . ')')
                                     )
                               );
    }


    public function getIdKey() {
        return Entity\Anzeige::TBL_COL_ID;
    }

}

?>
