<?php

namespace Administration\Model\Table;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;

use Administration\Model;

abstract class AbstractTable implements Model\ITable {


//    const ORACLE_TODAY_STRING = 'trunc(sysdate)';
    const ORACLE_TODAY_STRING = 'NOW()';

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll() {

        return $this->tableGateway->select(
            function(Select $select) {
                $select =  $this->getColumns($select);
                return $this->getJoin($select);
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function get($id) {

        $idKey = $this->getIdKey();

        $rowset = $this->tableGateway->select(
            function(Select $select) use ($id, $idKey) {
                $select = $this->getColumns($this->getJoin($select));
                $select->where($this->tableGateway->getTable() . "." . $idKey . '=' . (int) $id);
            }
        );

        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Model\IEntity $entity){

        $id = (int) $entity->getId();

        if ($id == 0) {
            $this->tableGateway->insert($entity->toDbArray());

            return $this->tableGateway->getLastInsertValue();
        }

        if ($this->get($id)) {
            $this->tableGateway->update($entity->toDbArray(), array($this->getIdKey() => $id));
            return $id;
        }

        throw new \Exception('Form id does not exist');

    }

    /**
     * {@inheritDoc}
     */
    public function delete($id){
        $this->tableGateway->delete(array($this->getIdKey() => $id));
    }


    protected abstract function getColumns(Select $select);
    protected abstract function getJoin(Select $select);


    protected abstract function getIdKey();
}

?>
