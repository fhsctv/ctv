<?php

namespace Campustv\Model\Table;



use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;


use Campustv\Model        as Model;
use Campustv\Model\Entity as Entity;

class Url extends AbstractTable {



    /**
     *
     * @param \Zend\Db\TableGateway\TableGateway $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway) {
        parent::__construct($tableGateway);
    }


    /**
     *
     * @param  Campustv\Model\IEntity $urlModel $urlModel
     * @return int id of the new url
     * @todo implement return of id with $this->tableGateway->getLastInsertValue(); when available in ZF2
     */
    public function save(Model\IEntity $urlModel) {

        if(!$urlModel->getUrl()){
            throw new \Exception('Url is required for saving Url!');
        }


        $id = parent::save($urlModel);

        if($id){
            return $id;
        }

        /*
         * The following is needed as $this->tableGateway->getLastInsertValue()
         * is not implemented yet
         */
        //TODO Update Zend Framework 2 and look if getLastGeneratedValue() in Zend\Db\Adapter\Driver\Oci8\Connection is implemented.
        //if so, replace the following code with return $this->tableGateway->getLastInsertValue();

        return $this->getMaxId($urlModel);

    }


    public function getIdKey() {
        return Entity\Url::TBL_COL_ID;
    }


    //-------------------------------------------------------- PROTECTED METHODS

    protected function getColumns(Select $select) {
        return $select;
    }

    protected function getMaxId($urlModel){

        $idResultSet = $this->tableGateway->select(
            function(Select $select) use ($urlModel) {

                $select->columns(array(Entity\Url::TBL_COL_ID =>
                                        new Expression('max('. Entity\Url::TBL_COL_ID .')')
                            )
                        );
                $select->where(array(Entity\Url::TBL_COL_URL => $urlModel->getUrl()));


               return $select;
            }
        );

        $urlModel = $idResultSet->current();

        return $urlModel->getId();
    }

    protected function getJoin(Select $select) {
        return $select;
    }
}

?>
